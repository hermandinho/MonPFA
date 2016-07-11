<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\User;

/**
 * ProjectModerator
 *
 * @ORM\Table(name="project_moderator")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ProjectModeratorRepository")
 */
class ProjectModerator
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
     *  @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User")
     */
    private $member;

    /**
     * @var Project
     *  @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\Project", inversedBy="members")
     */
    private $project;

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
     * Set member
     *
     * @param \PFA\MainBundle\Entity\User $member
     *
     * @return ProjectModerator
     */
    public function setMember(\PFA\MainBundle\Entity\User $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \PFA\MainBundle\Entity\User
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     *
     * @return ProjectModerator
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
}
