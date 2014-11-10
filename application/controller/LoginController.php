<?php
/**
 * Login controller
 * @author Serge Naumovych
 */


class LoginController extends Controller {

    public function index(){

        if(!(isset($_POST['login']) || isset($_POST['pass']))){
            echo $this->twig->render('login.html.twig', array("lang" => $this->lang['login']));
            return;
        }

        $login = $this->validate($_POST["login"]);
        $pass = $this->validate($_POST["pass"]);

        $user = $this->em->getRepository("User")->findBy(array("login" => $login, "pass" => $pass, "deleted" => 0), null, 1);

        //var_dump($user);
        if(isset($user[0])){

            $_SESSION['user'] = $user[0];
            $userType = $user[0]->getType()->getId();
            $_SESSION['user_type'] = $userType;
            $this->checkAccess($userType);
        } else {

            echo $this->twig->render('login.html.twig', array('error' => 'Login or Password is incorrect!', "lang" => $this->lang['login']));
        }
    }

}