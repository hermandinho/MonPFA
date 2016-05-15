<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\Calender;
use PFA\MainBundle\Entity\ChatRoom;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ProjectRepository")
 */
class Project extends BaseEntity
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
     */
    private $chatRoom;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MainBundle\Entity\User")
     *
     */
    //private $members;

    /**
     * @var Calender
     *
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Calender", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $calender;

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
     * @param \PFA\CoreBundle\Entity\ShareZone $ressources
     *
     * @return Project
     */
    public function setRessources(\PFA\CoreBundle\Entity\ShareZone $ressources = null)
    {
        $this->ressources = $ressources;

        return $this;
    }

    /**
     * Get ressources
     *
     * @return \PFA\CoreBundle\Entity\ShareZone
     */
    public function getRessources()
    {
        return $this->ressources;
    }

    /**
     * Set forum
     *
     * @param \PFA\CoreBundle\Entity\Forum $forum
     *
     * @return Project
     */
    public function setForum(\PFA\CoreBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \PFA\CoreBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Set chatRoom
     *
     * @param \PFA\MainBundle\Entity\ChatRoom $chatRoom
     *
     * @return Project
     */
    public function setChatRoom(\PFA\MainBundle\Entity\ChatRoom $chatRoom = null)
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    /**
     * Get chatRoom
     *
     * @return \PFA\MainBundle\Entity\ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }
}
