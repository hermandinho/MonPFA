<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 16/05/2016
 * Time: 23:58
 */

namespace PFA\MaillingBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\MaillingBundle\Entity\MailBox;

class MailBoxManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * MailFolderManager constructor.
     * @param EntityManager $entityManager
     * @internal param MailFolderRepository $repository
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getMailBoxData(MailBox $mailBox)
    {
        return $this->em->getRepository("PFAMaillingBundle:Mail")->getMailBoxData($mailBox);
    }
}