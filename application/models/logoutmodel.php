<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 26.06.14
 * Time: 15:43
 */

class LogoutModel extends Model{


    function __construct(PDO $db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }

    }


    /**
     * @param $uuid
     * @return bool
     * @throws ModelException
     */
    public function logout($uuid)
    {
        try {
            $this->deleteSessions($uuid);
            $sql = "UPDATE sessions SET deleted = 1 WHERE uuid = :uuid";

            $query = $this->db->prepare($sql);
            $query->execute(array(":uuid" => $uuid));

            if($query->rowCount() > 0){
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function deleteSessions($uuid){
        try {
            $sql = "SELECT session_id FROM sessions WHERE uuid = :uuid AND deleted = 0";
            $query = $this->db->prepare($sql);
            $query->execute(array(":uuid" => $uuid));

            if($query->rowCount() > 0){
                Session::closeAllSessions($query->fetchAll(PDO::FETCH_COLUMN));
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }
    }
} 