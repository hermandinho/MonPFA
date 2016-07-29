<?php

namespace PFA\MaillingBundle\Repository;
use PFA\MaillingBundle\Entity\Mail;
use PFA\MaillingBundle\Entity\MailBox;

/**
 * MailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailRepository extends \Doctrine\ORM\EntityRepository
{
    public function getMailBoxData(MailBox $mailBox)
    {
        $query = $this->createQueryBuilder("m")
                ->where("m.mailBox = :mailBox")
                ->setParameter("mailBox", $mailBox)
                ->setParameter("sender", $mailBox->getOwner())
                ->orWhere("m.receiver = :reciever")
                ->andWhere("m.parent IS NULL")
                ->andWhere("m.sender = :sender")
                ->setParameter("reciever", $mailBox->getOwner())
                ->andWhere("m.is_visible = :visible")
                ->setParameter("visible", true)
                ;
        //echo $query->getQuery()->getSQL().PHP_EOL;
        return $query->getQuery()->getResult();
    }
    
    public function getMailChildren(Mail $mail)
    {
        $query = $this->createQueryBuilder("m")
                ->where("m.parent = :parent")
                ->setParameter("parent", $mail);
        
        return $query->getQuery()->getResult();
    }
}
