<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\User;

/**
 * ForumInteractions
 *
 * @ORM\Table(name="forum_interactions")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ForumInteractionsRepository")
 */
class ForumInteractions
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var ForumInteractions
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent = null;

    /**
     * @var Forum
     * 
     * @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\Forum", inversedBy="interactions", cascade={"persist","remove"})
     */
    private $forum;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="forumInteraction")
     */
    private $owner;

    /**
     * @var ForumInteractions
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date = null;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ForumInteractionAnswer", mappedBy="forumInteraction", orphanRemoval=true, cascade={"persist"})
     */
    private $answers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", options={"default": 0})
     */
    private $status = 0;

    /**
     * ForumInteractions constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
     * Set subject
     *
     * @param string $subject
     *
     * @return ForumInteractions
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return ForumInteractions
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set forum
     *
     * @param \PFA\CoreBundle\Entity\Forum $forum
     *
     * @return ForumInteractions
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
     * Set owner
     *
     * @param \PFA\MainBundle\Entity\User $owner
     *
     * @return ForumInteractions
     */
    public function setOwner(\PFA\MainBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \PFA\MainBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return ForumInteractions
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ForumInteractions
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add answer
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractionAnswer $answer
     *
     * @return ForumInteractions
     */
    public function addAnswer(\PFA\CoreBundle\Entity\ForumInteractionAnswer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractionAnswer $answer
     */
    public function removeAnswer(\PFA\CoreBundle\Entity\ForumInteractionAnswer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    function __toString()
    {
        return "Intération #".$this->getId(). "(" . $this->getSubject() . ")";
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return ForumInteractions
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
}
