<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 12.06.14
 * Time: 16:05
 */

class Error {
    private $message;

    private $code;

    public function __construct($msg = "", $code = 0){
        $this->message = $msg;
        $this->code = $code;
    }
    /**
     * @param null $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

} 