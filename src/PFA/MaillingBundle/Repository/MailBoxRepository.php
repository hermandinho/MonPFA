<?php

namespace PFA\MaillingBundle\Repository;
use PFA\MaillingBundle\Entity\MailBox;

/**
 * MailBoxRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailBoxRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param MailBox $mailBox
     * @return array
     */
    public function getMailBoxData(MailBox $mailBox)
    {
        $query = $this->createQueryBuilder("m")
                ->where("m.owner = :boxOwner")
                ->setParameter("boxOwner", $mailBox->getOwner())
                ->andWhere("m.emails")
                ->getQuery();
        echo $query->getSQL();
        return $query->getArrayResult();
    }
}
