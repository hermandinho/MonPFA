<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 16/05/2016
 * Time: 14:47
 */

namespace PFA\MaillingBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\MaillingBundle\Repository\MailFolderRepository;
use PFA\MainBundle\Entity\User;

class MailFolderManager
{

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * MailFolderManager constructor.
     * @param MailFolderRepository $repository
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param User $user
     * @return MailFolderRepository
     */
    public function getUserFolders(User $user)
    {
        return $this->em->getRepository("PFAMaillingBundle:MailFolder")->getUserFolders($user);
    }
}