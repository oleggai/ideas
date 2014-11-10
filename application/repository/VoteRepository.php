<?php
use Doctrine\ORM\EntityRepository;

class VoteRepository extends EntityRepository
{
    public function findAllByUserId($id = 0){
        $query = $this->getEntityManager()
            ->createQuery("SELECT v FROM Vote v JOIN v.user u WHERE u.id = :id")
            ->setParameter("id", $id);

        $votes = $query->execute();

        return $votes;
    }
}