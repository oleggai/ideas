<?php
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findActiveByUserType(UserType $userType){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('User' , "u")
            ->where("u.type = :type")
            ->andWhere("u.deleted = 0")
            ->setParameter("type", $userType);


        return $qb->getQuery()->execute();

    }
}