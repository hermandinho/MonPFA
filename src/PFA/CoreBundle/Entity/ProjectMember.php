<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\User;

/**
 * ProjectMember
 *
 * @ORM\Table(name="project_member")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ProjectMemberRepository")
 */
class ProjectMember
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *  @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="")
     */
    private $memeber;


    /**
     * @var Project
     *  @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\Project", inversedBy="members")
     */
    private $project;

    /**
     * @var string
     * @ORM\Column(name="member_type", type="string", length=255, nullable=true)
     */
    private $memberType;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set memeber
     *
     * @param \PFA\MainBundle\Entity\User $memeber
     *
     * @return ProjectMember
     */
    public function setMemeber(\PFA\MainBundle\Entity\User $memeber = null)
    {
        $this->memeber = $memeber;

        return $this;
    }

    /**
     * Get memeber
     *
     * @return \PFA\MainBundle\Entity\User
     */
    public function getMemeber()
    {
        return $this->memeber;
    }

    /**
     * Set project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     *
     * @return ProjectMember
     */
    public function setProject(\PFA\CoreBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \PFA\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set memberType
     *
     * @param string $memberType
     *
     * @return ProjectMember
     */
    public function setMemberType($memberType)
    {
        $this->memberType = $memberType;

        return $this;
    }

    /**
     * Get memberType
     *
     * @return string
     */
    public function getMemberType()
    {
        return $this->memberType;
    }

    function __toString()
    {
        return $this->memeber->getNom() . " ". $this->memeber->getPrenom();
    }
}
