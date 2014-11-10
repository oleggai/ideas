<?php
/**
 * Created by PhpStorm.
 * User: олег
 * Date: 20.08.14
 * Time: 15:45
 */

final class Utility {
    public static function trim(array $mass) {
        $res = array();
        foreach($mass as $key=>$val) {

            $res[$key] = strip_tags(trim($val));
        }
        return $res;
    }
}