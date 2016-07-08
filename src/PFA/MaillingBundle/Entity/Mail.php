<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\User;use JMS\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailRepository")
 */
class Mail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("mail_box")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @Groups("mail_box")
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Groups("mail_box")
     */
    private $body;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=true)
     * @Groups("mail_box")
     */
    private $isRead;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Groups("mail_box")
     */
    private $date;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="sender", referencedColumnName="id", unique=false)
     *
     * @Groups("mail_box")
     */
    private $sender;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id", unique=false)
     */
    private $receiver;

    /**
     * @var MailBox
     * @ORM\ManyToOne(targetEntity="PFA\MaillingBundle\Entity\MailBox", inversedBy="emails")
     */
    private $mailBox;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MaillingBundle\Entity\MailAttachements", mappedBy="mail")
     * @Groups("mail_box")
     */
    private $attachements;

    /**
     * @var MailFolder
     *@ORM\ManyToOne(targetEntity="PFA\MaillingBundle\Entity\MailFolder")
     * @Groups("mail_box")
     */
    private $folder;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MaillingBundle\Entity\MailAnswer", mappedBy="parent")
     */
    private $answers;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->attachements = new ArrayCollection();
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

    /**
     * Set mailBox
     *
     * @param \PFA\MaillingBundle\Entity\MailBox $mailBox
     *
     * @return Mail
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
     * Set folder
     *
     * @param \PFA\MaillingBundle\Entity\MailFolder $folder
     *
     * @return Mail
     */
    public function setFolder(\PFA\MaillingBundle\Entity\MailFolder $folder = null)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return \PFA\MaillingBundle\Entity\MailFolder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Mail
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
     * Add attachement
     *
     * @param UploadedFile $attachement
     *
     * @return Mail
     */
    public function addAttachement(UploadedFile $attachement)
    {
        $this->attachements[] = $attachement;

        return $this;
    }

    /**
     * Remove attachement
     *
     * @param \PFA\MaillingBundle\Entity\MailAttachements $attachement
     */
    public function removeAttachement(\PFA\MaillingBundle\Entity\MailAttachements $attachement)
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
     * Add answer
     *
     * @param \PFA\MaillingBundle\Entity\Mail $answer
     *
     * @return Mail
     */
    public function addAnswer(\PFA\MaillingBundle\Entity\Mail $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \PFA\MaillingBundle\Entity\Mail $answer
     */
    public function removeAnswer(\PFA\MaillingBundle\Entity\Mail $answer)
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
}
