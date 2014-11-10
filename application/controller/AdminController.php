<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 15:47
 */

class AdminController extends Controller {

    protected function setOptions(){
        //$this->smarty = new Smarty();
        $this->loader = new Twig_Loader_Filesystem("public/templates/admin");
        $this->twig = new Twig_Environment($this->loader);
    }

    public function index(){
        $this->users();
    }

    public function topics(){

        $repository = $this->em->getRepository("Topic");
        $qb = $repository->createQueryBuilder('u');
        $qb->where('u.creator != :creator')
            ->andWhere('u.deleted = 0')
            ->setParameter('creator', $_SESSION['user']->getId())
            ->orderBy("u.date_created", "DESC");

        $topics = $qb->getQuery()
            ->getResult();

        foreach($topics as $topic){
            $topic->calculateMark();
         }

        echo $this->twig->render("topics.html.twig", array("topics" => $topics, "lang" => $this->lang['admin']));
    }

    private function comments(){

        $comments = $this->em->getRepository("Comment")->findAll();
        echo $this->twig->render("comments.html.twig", array("comments" => $comments, "lang" => $this->lang['admin']));
    }

    public function users(){
        $userType = $this->em->getRepository("UserType")->findOneBy(array("id" => ROLE_USER));
        $users = $this->em->getRepository("User")->findActiveByUserType($userType);

        echo $this->twig->render("users.html.twig", array("users" => $users, "lang" => $this->lang['admin']));
    }

    public function profile(){
        //$userType = $this->em->getRepository("UserType")->findOneBy(array("id" => ROLE_ADMIN));
        $user = $this->em->getRepository("User")->findOneBy(array("id" => $_SESSION['user']->getId()));

        echo $this->twig->render("profile.html.twig", array("user" => $user, "lang" => $this->lang['admin']));
    }


    public function shared(){
        $topics = $this->em->getRepository("Topic")->findActiveByUserId($_SESSION['user']->getId());

        echo $this->twig->render("topics.html.twig", array("topics" => $topics, "admin" => true, "lang" => $this->lang['admin']));
    }

} 