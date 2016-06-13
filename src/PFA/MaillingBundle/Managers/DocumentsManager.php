<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 13/06/2016
 * Time: 11:11
 */

namespace PFA\MaillingBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\CoreBundle\Entity\Project;
use PFA\MainBundle\Entity\Documents;

class DocumentsManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * DocumentsManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Project $project
     * @return array|\PFA\MainBundle\Entity\Documents[]
     */
    public function getMainDocuments(Project $project)
    {
        return $this->em->getRepository("PFAMainBundle:Documents")->findBy(['shareZone' => $project->getRessources(), "parent" => null]);
    }

    /**
     * @param Documents $parent
     * @return int
     */
    public function doDocChildVersion(Documents $parent)
    {
        return count($this->em->getRepository("PFAMainBundle:Documents")->findBy(["parent" => $parent]));
    }
}