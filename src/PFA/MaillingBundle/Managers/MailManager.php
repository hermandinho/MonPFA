<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 18/05/2016
 * Time: 16:26
 */

namespace PFA\MaillingBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\MaillingBundle\Entity\Mail;

class MailManager
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

    /**
     * @param Mail $mail
     * @return array
     */
    public function getMailChildren(Mail $mail)
    {
        return $this->em->getRepository("PFAMaillingBundle:Mail")->getMailChildren($mail);
    }
}