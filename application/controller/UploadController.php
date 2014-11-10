<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 08.08.14
 * Time: 16:44
 */

class UploadController extends Controller {

    public function video($filename = null){
         echo $this->twig->render("video.html.twig", array("file" => $filename));
    }

} 