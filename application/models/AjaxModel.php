<?php
/**
 * Created by PhpStorm.
 * User: олег
 * Date: 20.08.14
 * Time: 15:49
 */

class AjaxModel {

    public $db = null;
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function selectNewTopics($time, $id_creator) {
        try {
            $sql = "SELECT id, creator FROM topics
                    WHERE date_created > :time
                    AND creator <> :creator
                    AND deleted = '0'";

            $query = $this->db->prepare($sql);
            $query->execute(array(
                                 ":time"    => $time,
                                 ":creator" => $id_creator
                            ));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query->fetchAll();
        }
        catch(Exception $e) {
            return array();
        }
    }

    public function selectNewComments($time, $id_creator) {
        try {
            $sql = "SELECT id, topic FROM comments
                    WHERE date_created > :time
                    AND creator <> :creator
                    AND deleted = '0'";

            $query = $this->db->prepare($sql);
            $query->execute(array(
                    ":time"    => $time,
                    ":creator" => $id_creator
                ));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query->fetchAll();
        }
        catch(Exception $e) {
            return array();
        }
    }
}