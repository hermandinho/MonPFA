<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use JMS\Serializer\Annotation\Groups;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\Calender;
use PFA\MainBundle\Entity\ChatRoom;
use PFA\MainBundle\Entity\User;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"chat_message"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=true)
     */
    private $status;


    /**
     * @var ShareZone
     *
     * @ORM\OneToOne(targetEntity="PFA\CoreBundle\Entity\ShareZone", inversedBy="project", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $ressources;

    /**
     * @var Forum
     * @ORM\OneToOne(targetEntity="PFA\CoreBundle\Entity\Forum", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $forum;

    /**
     * @var ChatRoom
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\ChatRoom", cascade={"persist","remove"}, orphanRemoval=true)
     *
     * @Groups({"chat_message"})
     */
    private $chatRoom;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ProjectMember", mappedBy="project")
     */
    private $members;

    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="projects")
     *
     */
    private $owner;

    /**
     * @var Calender
     *
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Calender", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $calender;


    public function __construct()
    {
        $this->members = new ArrayCollection();
        //$this->ressources = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     *
     * @return Project
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ressources
     *
     * @param ShareZone $ressources
     *
     * @return Project
     */
    public function setRessources(ShareZone $ressources = null)
    {
        $this->ressources = $ressources;

        return $this;
    }

    /**
     * Get ressources
     *
     * @return ShareZone
     */
    public function getRessources()
    {
        return $this->ressources;
    }

    /**
     * Set forum
     *
     * @param Forum $forum
     *
     * @return Project
     */
    public function setForum(Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Set chatRoom
     *
     * @param ChatRoom $chatRoom
     *
     * @return Project
     */
    public function setChatRoom(ChatRoom $chatRoom = null)
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    /**
     * Get chatRoom
     *
     * @return ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }

    /**
     * Set owner
     *
     * @param User $owner
     *
     * @return Project
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set calender
     *
     * @param Calender $calender
     *
     * @return Project
     */
    public function setCalender(Calender $calender = null)
    {
        $this->calender = $calender;

        return $this;
    }

    /**
     * Get calender
     *
     * @return Calender
     */
    public function getCalender()
    {
        return $this->calender;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Project
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add member
     *
     * @param User $member
     *
     * @return Project
     */
    public function addMember(User $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param User $member
     */
    public function removeMember(User $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    function __toString()
    {
        return "Project #".$this->getId();
    }
}
