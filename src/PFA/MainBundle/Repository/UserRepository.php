<?php

namespace PFA\MainBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchUser($like) {
        $query = $this->createQueryBuilder("u")
                ->where("u.nom LIKE :nom")
                ->setParameter("nom", "%$like%")
                ->orWhere("u.prenom LIKE :prenom")
                ->setParameter("prenom", "%$like%")
                ->orWhere("u.email LIKE :email")
                ->setParameter("email", "%$like%");

        return $query->getQuery()->getResult();
    }
}
