<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 23/05/2016
 * Time: 10:31
 */

namespace PFA\CoreBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\CoreBundle\Entity\Project;
use PFA\MainBundle\Entity\User;

class UserManager
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
     * @return array|\PFA\MainBundle\Entity\User[]
     */
    public function getUserList()
    {
        return $this->em->getRepository("PFAMainBundle:User")->findAll();
    }

    public function getPrivateChat(User $user1, User $user2, Project $project)
    {
        return $this->em->getRepository("PFAMainBundle:ChatRoomMessages")->getUserChatHistory($user1,$user2,$project);
    }
}