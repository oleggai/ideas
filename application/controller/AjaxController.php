<?php
/**
 * Created by PhpStorm.
 * User: олег
 * Date: 20.08.14
 * Time: 15:52
 */

class AjaxController extends Controller {

    public $ajax_model = null;
    public $url = array();
    public $post = array();
    public $time = null;

    public function loadNewTopics() {

        $this->setParam();
        $topics = $this->ajax_model->selectNewTopics($this->time, $_SESSION["user"]->getId());

        foreach($topics as $key=>$val) {
            if($val["creator"] == AdminId::adminId) {
                $this->url[$key] = "'".URL.Url::main.Url::admin.$val["id"]."'";
            }
            else {
                $this->url[$key] = URL.Url::main.Url::topics.$val["id"];
            }
        }
        echo json_encode($this->url);
    }

    public function loadNewComments() {
        $this->setParam();
        $messages = $this->ajax_model->selectNewComments($this->time, $_SESSION["user"]->getId());

        foreach($messages as $key=>$val) {

                $this->url[$key] = URL.Url::main.Url::topics.$val["topic"]."/".$val["id"];

        }
        echo json_encode($this->url);
    }

    public function setParam() {
        $this->ajax_model = new AjaxModel(Connection::getConnection());
        $this->post = Utility::trim($_POST);
        $this->time = new DateTime();
        $this->time->setTimestamp($this->post["time"]);
        $this->time = $this->time->format("Y-m-d H:i:s");
    }
}