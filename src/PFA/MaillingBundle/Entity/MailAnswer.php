<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use PFA\MainBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * MailAnswer
 *
 * @ORM\Table(name="mail_answer")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailAnswerRepository")
 */
class MailAnswer
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
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @Groups("mail_box")
     */
    private $subject;

    /**
     * @var Mail
     *
     * @ORM\ManyToOne(targetEntity="PFA\MaillingBundle\Entity\Mail", cascade={"remove"}, inversedBy="answers")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MaillingBundle\Entity\MailAttachements", mappedBy="mailAnswer", orphanRemoval=true, cascade={"persist","remove"})
     * @Groups("mail_box")
     */
    private $attachements;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="sender", referencedColumnName="id", unique=false)
     *
     * @Groups("mail_box")
     */
    private $sender;

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
     * Set body
     *
     * @param string $body
     *
     * @return MailAnswer
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return MailAnswer
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
     * Constructor
     */
    public function __construct()
    {
        $this->attachements = new ArrayCollection();
    }

    /**
     * Set parent
     *
     * @param Mail $parent
     *
     * @return MailAnswer
     */
    public function setParent(Mail $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Mail
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param UploadedFile $attachement
     * @return $this
     */
    public function addAttachement(UploadedFile $attachement = null)
    {
        $this->attachements[] = $attachement;

        return $this;
    }

    /**
     * Remove attachement
     *
     * @param MailAttachements $attachement
     */
    public function removeAttachement(MailAttachements $attachement)
    {
        $this->attachements->removeElement($attachement);
    }

    /**
     * Get attachements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachements()
    {
        return $this->attachements;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return MailAnswer
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
     * Set sender
     *
     * @param \PFA\MainBundle\Entity\User $sender
     *
     * @return MailAnswer
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

    function __toString()
    {
        return "ANS #".$this->getId();
    }
}
