<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 11:24
 */
/*
 * обмеження доступу для різних типів користувачів
 */
abstract class UserTypes {

    public static  $adminPages = array("admin", "users", "topics", "comments");

    public static  $userPages = array("main", "ajax");
}