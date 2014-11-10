<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 25.06.14
 * Time: 15:37
 */

class LoginModel extends Model {


    /**
     * @var PDO
     */
    private $db;

    /**
     * @param $login
     * @param $pass
     * @return User | boolean
     * @throws ModelException
     */
    public function login($login, $pass)
    {
        try {
            $this->db = Connection::getConnection();

            //$sql = "SELECT COUNT(id) AS res  FROM users WHERE email = :email AND password = MD5(CONCAT(salt, MD5(:pass)))";
            $sql = "SELECT *  FROM users WHERE login = :login AND password = :pass LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->setFetchMode(PDO::FETCH_CLASS, 'User');
            $query->execute(array(":login" => $login, ":pass" => $pass));

            if($res = $query->fetch()){
                var_dump($res);
                return true;
            }
            return false;
        } catch (Exception $e) {
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }
    }
}