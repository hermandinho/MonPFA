<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\User;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailRepository")
 */
class Mail extends BaseEntity
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
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=true)
     */
    private $isRead;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\User", orphanRemoval=true,cascade={"persist","remove"})
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")
     */
    private $sender;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\User",orphanRemoval=true, cascade={"persist","remove"})
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id")
     */
    private $receiver;

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
     * @return Mail
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
     * Set body
     *
     * @param string $body
     *
     * @return Mail
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return Mail
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return bool
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set sender
     *
     * @param \PFA\MainBundle\Entity\User $sender
     *
     * @return Mail
     */
    public function setSender(\PFA\MainBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \PFA\MainBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \PFA\MainBundle\Entity\User $receiver
     *
     * @return Mail
     */
    public function setReceiver(\PFA\MainBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \PFA\MainBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
