<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 15:25
 */

class MainController extends Controller {

    protected function setOptions(){
        //$this->smarty = new Smarty();
        $this->loader = new Twig_Loader_Filesystem("public/templates/main");
        $this->twig = new Twig_Environment($this->loader);
    }

    public function index(){
        if(isset($_SESSION['user_type']))
            $this->checkAccess($_SESSION['user_type']);
        else
            $this->checkAccess();
    }

    public function topics($id_topic = 0, $id_comment = 0){

        $topics = $this->em->getRepository("Topic")->findActiveByUserType(ROLE_USER);
        foreach($topics as $topic){
            $topic->calculateMark();
        }
        $this->setUserMark($topics);


        $userOld = $_SESSION['user'];
        if(!$_SESSION['user']->getFirstStart()){

            $user = $this->em->getRepository("User")
                ->findOneBy(array("id" => $_SESSION['user']->getId()));

            $user->setFirstStart(true);
            $this->em->persist($user);
            $this->em->flush();


        }


       echo $this->twig->render("topics.html.twig",
           array("topics" => $topics, "lang" => $this->lang['main'], "user" => $userOld,
                 "id_topic" => $id_topic, "id_comment" => $id_comment));

        $_SESSION['user']->setFirstStart(true);

/*
        if(!$_SESSION['user']->getFirstStart()){
            $user = $this->em->getRepository("User")
                ->findOneBy(array("id" => $_SESSION['user']->getId()));

            $user->setFirstStart(true);
            $this->em->persist($user);
            $this->em->flush();

            $_SESSION['user'] = $user;
        }
*/
    }



    public function myTopics($id_topic = 0, $id_comment = 0){
        $topics = $this->em->getRepository("Topic")->findActiveByUserId($_SESSION['user']->getId());
        foreach($topics as $topic){
            $topic->calculateMark();
        }
        $this->setUserMark($topics);
        echo $this->twig->render("mytopics.html.twig",
            array("topics" => $topics, "lang" => $this->lang['main'], "user" => $_SESSION['user'],
                  "id_topic" => $id_topic, "id_comment" => $id_comment));
    }

    public function shared($id_topic = 0, $id_comment = 0){
        $topics = $this->em->getRepository("Topic")->findActiveByUserType(ROLE_ADMIN);
        echo $this->twig->render("shared.html.twig",
            array("topics" => $topics, "lang" => $this->lang['main'], "user" => $_SESSION['user'],
                  "id_topic" => $id_topic, "id_comment" => $id_comment));
    }

    public function createTopic(){
        $errors = array();
        $success = array();

        try{
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $this->createNewTopic();
                array_push($success, "Posted!");
            }
        } catch(Exception $e){
            array_push($errors, $e->getMessage());
        }

        if($_SESSION['user_type'] == ROLE_USER)
            echo $this->twig->render("newtopic.html.twig", array("errors" => $errors,
                                                                 "successes" => $success,
                                                                 "videoFormats" => TopicsController::$SUPPORTED_VIDEO_FORMATS,
                                                                 "lang" => $this->lang['main'],
                                                                 "user" => $_SESSION['user']));
    }

    //$.post('/ideas/main/createComment', {"topic": 10, "comment": "sdfsdfsdfsdfsdfsdf"})
    public function createComment(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $res = array("status" => false, "msg" => "", "name" => "", "surname" => "", "commentsCount" => 0);
            if(!isset($_POST['topic']) || !isset($_POST['comment'])){
                echo json_encode($res);
            } else {
                try{
                    $creator = $this->em->getRepository('User')->findOneBy(array("id" => $_SESSION['user']->getId()));
                    $topic = $this->em->getRepository('Topic')->findOneBy(array("id" => intval($_POST['topic'])));
                    $comment = new Comment();
                    $comment->setCreator($creator)
                        ->setComment($this->validate($_POST['comment']))
                        ->setTopic($topic)
                        ->setDateCreated(new DateTime())
                        ->setDeleted(false);


                    $this->em->persist($comment);
                    $this->em->flush();
                    $res['status'] = true;
                    $res['name'] = $_SESSION['user']->getName();
                    $res['surname'] = $_SESSION['user']->getSurname();

                    $res['commentsCount'] = $topic->getActiveCommentsCount();
                    echo json_encode($res);
                } catch (Exception $e){
                    //var_dump($e);
                    echo json_encode($res);
                }
            }

        } else {
            if(isset($_SESSION['user_type']))
                $this->checkAccess($_SESSION['user_type']);
            else
                $this->checkAccess();
        }
    }

    // $.post('/ideas/main/createVote', {"topic": 10, "mark": 10})
    public function createVote(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(!isset($_POST['topic']) || !isset($_POST['mark'])){
                echo false;
            } else {
                try{
                    $mark = ($_POST['mark'] <= 10 || $_POST['mark'] >= 0) ? intval($_POST['mark']) : 0;
                    $creator = $this->em->getRepository('User')->findOneBy(array("id" => $_SESSION['user']->getId()));
                    $topic = $this->em->getRepository('Topic')->findOneBy(array("id" => intval($_POST['topic'])));
                    $vote = $this->em->getRepository("Vote")->findOneBy(array("user" => $creator, "topic" => $topic));
                    if(!$vote){
                        $vote = new Vote();
                        $vote->setUser($creator)
                            ->setTopic($topic);
                    }

                    $vote->setMark($mark);
                    $topic->calculateMark();

                    $this->em->persist($vote);
                    $this->em->flush();

                    echo json_encode(array("new_mark"=> $topic->getMark()));

                } catch (Exception $e){
                    echo false;
                }
            }

        } else {
            if(isset($_SESSION['user_type']))
                $this->checkAccess($_SESSION['user_type']);
            else
                $this->checkAccess();
        }


    }


    private function createNewTopic(){

        if(empty($_POST))
            throw new Exception("POST is empty");

        $msg = $this->validate($_POST['topic-msg']);
        $title = $this->validate($_POST['topic-title']);
        $link = $this->getLink();
        $tmp = $this->getFileType($link['type']);
        $link['type'] = $tmp['code'];


        $creator = $this->em->getRepository("User")->findOneBy(array("id" => $_SESSION['user']->getId()));
        $topic = new Topic();
        $topic->setCreator($creator)
            ->setTitle($title)
            ->setDateCreated(new DateTime())
            ->setDeleted(false)
            ->setMessage($msg)
            ->setPicture($link['link'])
            ->setLinkType($link['type']);

        if(isset($link['file_type'])){
            $topic->setFileType($link['file_type']);
            if($link['type'] == 1 && !in_array($_FILES['topic-file']['type'], TopicsController::$SUPPORTED_VIDEO_FORMATS)){
                throw new Exception("Format not supported");
            }
        }

        $this->em->persist($topic);
        $this->em->flush();
    }


    private function getLink(){
        if(isset($_FILES['topic-file']) && $_FILES['topic-file']['name'] ){

            return $this->uploadFile();
        }

        if($_POST['topic-type'] == "video"){

            $start =  strpos($_POST['topic-link'], "src=\"");
            $end =  strpos($_POST['topic-link'], "\"", $start+5);
            $_POST['topic-link'] =  substr($_POST['topic-link'], $start+5, $end-$start-5);

            if(!$start || !$end || empty($_POST['topic-link']))
                throw new Exception("Incorrect link!");
        }

        return array(
            "link" => $_POST['topic-link'],
            "type" => $this->validate($_POST['topic-type'])
        );
    }

    private function uploadFile(){
        $uploaddir = 'uploads/';
        $type = $this->getFileType($_FILES['topic-file']['type']);
        $uploadfile = $uploaddir . $type['name'] . "/" . uniqid() . basename($_FILES['topic-file']['name']);

        if (!move_uploaded_file($_FILES['topic-file']['tmp_name'], $uploadfile)) {
            throw new Exception("Can't upload file!");
        }

        return array(
            "link" => URL . $uploadfile,
            "type" => $type['name'],
            "file_type" => $_FILES['topic-file']['type']
        );
    }

    private function getFileType($filename){
        $type = null;
        if(substr( $filename, 0, 5 ) === "video"){
            $type = array(
                "name" => "video",
                "code" => 1
            );
        } elseif (substr( $filename, 0, 5 ) === "image"){
            $type = array(
                "name" => "image",
                "code" => 2
            );
        } else {
            throw new Exception("Not correct file type");
        }

        return $type;
    }

    private function setUserMark($topics){
        $votes = $this->em->getRepository("Vote")->findAllByUserId($_SESSION['user']->getId());
        foreach($topics as $topic){
            foreach($votes as $vote){
                if($vote->getTopic()->getId() == $topic->getId()){
                    $topic->setUserMark($vote->getMark());
                    break;
                }
            }
        }
    }

} 