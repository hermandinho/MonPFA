<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 19/06/2016
 * Time: 10:12
 */

namespace PFA\CoreBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\CoreBundle\Entity\ForumInteractions;
use PFA\CoreBundle\Entity\Project;

class ForumManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ForumManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadForum(Project $project)
    {
        $forum = $project->getForum();
        $interactions = $forum->getInteractions();

        return $forum->getInteractions();
    }

    private function sortForumData(ForumInteractions $a, ForumInteractions $b)
    {
        return $a->getDate() < $b->getDate();
    }


}