<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */

use \Doctrine\ORM\EntityManager;

class Controller
{
    /**
     * @type EntityManager
     * Doctrine 2 Entity Manager
     */
    protected $em;

    protected $loader;
    /**
     * @var Twig_Environment
     */
    protected $twig;
    /**
     * @var Smarty
     */
    protected $smarty;

    protected $lang;

    public static $language;

    function __construct(EntityManager $em)
    {
        $this->lang = json_decode(file_get_contents($this->getLang()), true);
        self::$language = $this->lang;
        $this->em = $em;
        $this->setOptions();

    }

    public function index(){
        $this->checkAccess();
    }

    protected function setOptions(){
       // $this->smarty = new Smarty();
        $this->loader = new Twig_Loader_Filesystem("public/templates");
        $this->twig = new Twig_Environment($this->loader);
    }


    public function validate($data){
        return trim(strip_tags($data));
    }

    protected function checkAccess($userType = 0){
        switch($userType){
            case ROLE_ADMIN:
                header("Location: " . URL . "admin");
                break;
            case ROLE_USER:
                header("Location: " . URL . "main/topics");
                break;
            default:
                header("Location: " . URL . "login");
                break;
        }

        exit;
    }


    protected function getLang(){
        //echo $_GET['l'];
        $lang = 'lang/tur/library.json';
        if (!isset($_COOKIE['lang'])) {
            setcookie("lang", "english");
        } else if (isset($_GET['l'])) {
             switch ($_GET['l']) {
                case "tur":
                    setcookie("lang", "turkish");
                    $lang = 'lang/tr/library.json';
                    break;
                default :
                    setcookie("lang", "english");
                    break;
            }
        } else {
            switch ($_COOKIE['lang']) {
                case "turkish":
                    $lang = 'lang/tr/library.json';
                    break;
                default :
                    break;
            }
        }

//        return "application/" . $lang;
        return "application/lang/tr/library.json";
    }

    public function loadModel($model_name)
    {
        require 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db);
    }

}
