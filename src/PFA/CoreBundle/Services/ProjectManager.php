<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 26/05/2016
 * Time: 20:43
 */

namespace PFA\CoreBundle\Services;


use Doctrine\ORM\EntityManager;
use PFA\MainBundle\Entity\User;

class ProjectManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ProjectManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param User $user
     * @return array|\PFA\CoreBundle\Entity\Project[]
     */
    public function getUserProjects(User $user)
    {
        $repository = $this->em->getRepository("PFACoreBundle:Project");
        $list = $repository->findBy(['owner' => $user]);
        return $list;
    }

}