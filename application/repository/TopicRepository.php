<?php
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository
{
    public function findAllByUserType($userType = ROLE_USER){
        if(!in_array($userType, array(ROLE_ADMIN, ROLE_USER))){
            return array();
        }


        //$qb = $this->getEntityManager()->createQueryBuilder("t");
        $query = $this->getEntityManager()
            ->createQuery("SELECT t FROM Topic t JOIN t.creator c WHERE c.type = :type ORDER BY t.id DESC")
            ->setParameter("type", $userType);

        $topics = $query->execute();

        return $topics;
    }

    public function findAllByUserId($id = 0){
        //$qb = $this->getEntityManager()->createQueryBuilder("t");
        $query = $this->getEntityManager()
            ->createQuery("SELECT t FROM Topic t JOIN t.creator c WHERE c.id = :id  ORDER BY t.id DESC")
            ->setParameter("id", $id);

        $topics = $query->execute();

        return $topics;
    }

    public function findActiveByUserType($userType = ROLE_USER){
        if(!in_array($userType, array(ROLE_ADMIN, ROLE_USER))){
            return array();
        }


        //$qb = $this->getEntityManager()->createQueryBuilder("t");
        $query = $this->getEntityManager()
            ->createQuery("SELECT t FROM Topic t JOIN t.creator c WHERE c.type = :type AND t.deleted = 0 ORDER BY t.id DESC")
            ->setParameter("type", $userType);

        $topics = $query->execute();

        return $topics;
    }

    public function findActiveByUserId($id = 0){
        $query = $this->getEntityManager()
            ->createQuery("SELECT t FROM Topic t JOIN t.creator c WHERE c.id = :id AND t.deleted = false  ORDER BY t.id DESC")
            ->setParameter("id", $id);

        $topics = $query->execute();

        return $topics;
    }
}