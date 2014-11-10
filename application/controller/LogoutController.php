<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 26.06.14
 * Time: 15:39
 */

class LogoutController extends Controller {

    public function index(){
        session_destroy();
        header('Location: ' . URL . 'login');
        return false;
    }


} 