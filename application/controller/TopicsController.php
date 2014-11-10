<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 15:53
 */

class TopicsController extends Controller {

    public static $SUPPORTED_VIDEO_FORMATS = array("video/mp4", "video/webm", "video/ogg");

    protected function setOptions(){
        //$this->smarty = new Smarty();
        $this->loader = new Twig_Loader_Filesystem("public/templates/admin");
        $this->twig = new Twig_Environment($this->loader);
    }

    public function index(){

        $topics = $this->em->getRepository("Topic")->findAllByUserType(ROLE_USER);

        echo $this->twig->render("topics.html.twig", array("topics" => $topics, "lang" => $this->lang['admin']));
    }

    public function create(){
        $errors = array();
        $success = array();

        try{
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $this->createTopic();
                array_push($success, "Posted!");
            }
        } catch(Exception $e){
            array_push($errors, $e->getMessage());
        }

        if($_SESSION['user_type'] == ROLE_ADMIN)
            echo $this->twig->render("newtopic.html.twig", array("errors" => $errors, "successes" => $success, "videoFormats" => self::$SUPPORTED_VIDEO_FORMATS, "lang" => $this->lang['admin']));
    }

    private function createTopic(){

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
            if($link['type'] == 1 && !in_array($_FILES['topic-file']['type'], self::$SUPPORTED_VIDEO_FORMATS)){
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

    public function delete($id){
        $topic = $this->changeStatus($id, true);
        if($topic){
            if($topic->getCreator()->getId() == ROLE_ADMIN){
                header("Location: " . URL . "admin/shared");
                exit;
            } else {
                header("Location: " . URL . "admin/topics");
                exit;
            }
        }

        //header("Location: " . $_SERVER['HTTP_REFERRER']);
        header("Location: " . URL . "admin/topics");
        exit;
    }

    public function activate($id){
        $topic = $this->changeStatus($id, false);
        if($topic){
            if($topic->getCreator()->getId() == ROLE_ADMIN){
                header("Location: " . URL . "admin/shared");
                exit;
            } else {
                header("Location: " . URL . "admin/topics");
                exit;
            }
        }

        //header("Location: " . $_SERVER['HTTP_REFERRER']);
        header("Location: " . URL . "admin/topics");
        exit;
    }

    /**
     * @param integer $id
     * @param boolean $status
     * @return null|Topic
     */
    private function changeStatus($id, $status){
        try{
            $topic = $this->em->getRepository("Topic")->findOneBy(array("id" => $id));
            if($topic){
                $topic->setDeleted($status);
                $this->em->persist($topic);
                $this->em->flush();
                return $topic;
            }

        } catch(Exception $e){
            //NOP
        }
    }

} 