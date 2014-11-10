<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 08.08.14
 * Time: 12:37
 */

class CommentsController extends Controller {

    public function setOptions(){}

    public function delete($id = null)
    {
        if (!$id || intval($id) < 1) {
            header("Location: " . URL);
            exit;
        }


        try {
            $comment =  $this->changeStatus($id, true);
            echo $comment->getId();
        } catch (Exception $e) {
            echo false;
        }
    }

    public function activate($id = null)
    {
        if (!$id || intval($id) < 1) {
            header("Location: " . URL);
            exit;
        }

        try {
            $comment =  $this->changeStatus($id, false);
            echo $comment->getId();
        } catch (Exception $e) {
            echo false;
        }
    }

    private function changeStatus($id, $deleted=false){
        $id = intval($id);
        $comment = $this->em->getRepository("Comment")->findOneBy(array("id" => $id));
        $comment->setDeleted($deleted);
        $this->em->persist($comment);
        $this->em->flush();
        return $comment;
    }

} 