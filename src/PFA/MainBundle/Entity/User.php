<?php

namespace PFA\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use FOS\UserBundle\Model\User as BaseUser;
use PFA\CoreBundle\Entity\ForumInteractions;
use PFA\MaillingBundle\Entity\MailBox;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var MailBox
     * @ORM\OneToOne(targetEntity="PFA\MaillingBundle\Entity\MailBox", mappedBy="owner", orphanRemoval=true)
     */
    private $mailBox;

    /**
     * @var MailBox
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Calender", mappedBy="owner", orphanRemoval=true)
     */
    private $calendar;
    

    /**
     * @var ForumInteractions
     * 
     * @ORM\OneToOne(targetEntity="PFA\CoreBundle\Entity\ForumInteractions", mappedBy="owner")
     */
    private $forumInteraction;

    /**
     * @var Calender
     *
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Calender", mappedBy="owner", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $calender;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="PFA\CoreBundle\Entity\Project")
     * @ORM\JoinTable(name="project_members",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="project_id", referencedColumnName="id")}
     * )
     *
     */
    private $projects;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->projects = new ArrayCollection();
    }


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
     * Set mailBox
     *
     * @param \PFA\MaillingBundle\Entity\MailBox $mailBox
     *
     * @return User
     */
    public function setMailBox(\PFA\MaillingBundle\Entity\MailBox $mailBox = null)
    {
        $this->mailBox = $mailBox;

        return $this;
    }

    /**
     * Get mailBox
     *
     * @return \PFA\MaillingBundle\Entity\MailBox
     */
    public function getMailBox()
    {
        return $this->mailBox;
    }

    /**
     * Set forumInteraction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $forumInteraction
     *
     * @return User
     */
    public function setForumInteraction(\PFA\CoreBundle\Entity\ForumInteractions $forumInteraction = null)
    {
        $this->forumInteraction = $forumInteraction;

        return $this;
    }

    /**
     * Get forumInteraction
     *
     * @return \PFA\CoreBundle\Entity\ForumInteractions
     */
    public function getForumInteraction()
    {
        return $this->forumInteraction;
    }

    /**
     * Set calender
     *
     * @param \PFA\MainBundle\Entity\Calender $calender
     *
     * @return User
     */
    public function setCalender(\PFA\MainBundle\Entity\Calender $calender = null)
    {
        $this->calender = $calender;

        return $this;
    }

    /**
     * Get calender
     *
     * @return \PFA\MainBundle\Entity\Calender
     */
    public function getCalender()
    {
        return $this->calender;
    }

    /**
     * Add project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     *
     * @return User
     */
    public function addProject(\PFA\CoreBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     */
    public function removeProject(\PFA\CoreBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Set calendar
     *
     * @param \PFA\MainBundle\Entity\Calender $calendar
     *
     * @return User
     */
    public function setCalendar(\PFA\MainBundle\Entity\Calender $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return \PFA\MainBundle\Entity\Calender
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
