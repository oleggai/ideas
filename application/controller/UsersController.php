<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 05.08.14
 * Time: 13:20
 */

class UsersController extends Controller {

    protected function setOptions(){
        //$this->smarty = new Smarty();
        $this->loader = new Twig_Loader_Filesystem("public/templates/admin");
        $this->twig = new Twig_Environment($this->loader);
    }

    public function index(){
        echo $this->twig->render("newuser.html.twig", array("lang" => $this->lang['admin']));
    }

    public function create(){
        $errors = array();
        $successes = array();

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            try{
                $user = $this->getPOSTUserInfo();
                $this->em->persist($user);
                $this->em->flush();
                array_push($successes, "User " . $user->getName() . " " . $user->getSurname());
            } catch(Exception $e){
                array_push($errors, "Something went wrong!");
            }
        }

        echo $this->twig->render("newuser.html.twig",
            array(
                "errors" => $errors,
                "successes" => $successes,
                "lang" => $this->lang['admin']
            ));
    }

    public function profile($id = 0){
        if($id === 0){
            header("Location: " . URL . "users");
            exit;
        }
        $user = $this->em->getRepository("User")->findOneBy(array("id" => $id));

        echo $this->twig->render("profile.html.twig", array("user" => $user, "lang" => $this->lang['admin']));
    }

    public function delete($id){
        $this->changeStatus($id, true);
        header("Location: " . URL . "admin/users");
    }

    public function activate($id){
        $this->changeStatus($id, false);
        header("Location: " . URL . "admin/users");
    }

    public function update(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $errors = array();
            $successes = array();
            try{
                $id = intval($_POST['id']);

                $user = $this->em->getRepository("User")->findOneBy(array("id" => $id));

                if($user){
                    $user = $this->checkUpdateInfo($user);
                    $this->em->persist($user);
                    $this->em->flush();
                    array_push($successes, $this->lang['admin']['saved']);
                } else {
                    array_push($errors, "Such user doesn't exists!");
                }



            } catch (Exception $e){
                array_push($errors, $this->lang['admin']['userExists']);

            }

            echo $this->twig->render("profile.html.twig", array(
                "errors" => $errors,
                "successes" => $successes,
                "user" => (isset($user) && $user)? $user : $this->getPOSTUserInfo(),
                "lang" => $this->lang['admin']

            ));

        }


    }


    private function checkUpdateInfo(User $user){
        $login = $this->validate($_POST['login']);
        $password = $this->validate($_POST['password']);
        $name = $this->validate($_POST['name']);
        $surname = $this->validate($_POST['surname']);

        $user->setLogin($login)
            ->setName($name)
            ->setSurname($surname);

        if($password)
            $user->setPass($password);

        return $user;
    }


    /**
     * @param integer $id
     * @param boolean $status
     */
    private function changeStatus($id, $status){
        try{
            $user = $this->em->getRepository("User")->findOneBy(array("id" => $id));
            if($user){
                $user->setDeleted($status);
                $this->em->persist($user);
                $this->em->flush();
            }
        } catch(Exception $e){
            //NOP
        }
    }

    /**
     * @return User
     */
    private function getPOSTUserInfo(){
        $login = $this->validate($_POST['login']);
        $password = $this->validate($_POST['password']);
        $name = $this->validate($_POST['name']);
        $surname = $this->validate($_POST['surname']);
        $userType = $this->em->getRepository("UserType")->findOneBy(array("id" => ROLE_USER));

        $user = new User();
        $user->setLogin($login)
            ->setType($userType)
            ->setPass($password)
            ->setName($name)
            ->setSurname($surname);

        return $user;
    }



} 