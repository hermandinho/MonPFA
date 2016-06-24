<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\User;

/**
 * ForumInteractionAnswer
 *
 * @ORM\Table(name="forum_interaction_answer")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ForumInteractionAnswerRepository")
 */
class ForumInteractionAnswer
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="")
     */
    private $owner;

    /**
     * @var ForumInteractions
     * @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\ForumInteractions", inversedBy="")
     */
    private $forumInteraction;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ForumInterationAnwser
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
     * Set content
     *
     * @param string $content
     *
     * @return ForumInterationAnwser
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
     * Set owner
     *
     * @param \PFA\MainBundle\Entity\User $owner
     *
     * @return ForumInteractionAnswer
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
     * Set forumInteraction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $forumInteraction
     *
     * @return ForumInteractionAnswer
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
}
