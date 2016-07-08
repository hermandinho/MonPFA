<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\User;

/**
 * MailBox
 *
 * @ORM\Table(name="mail_box")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailBoxRepository")
 */
class MailBox
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="mailBox")
     */
    private $owner;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MaillingBundle\Entity\Mail", mappedBy="mailBox", cascade={"persist","remove", "merge"}, orphanRemoval=true)
     */
    private $emails;


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
     * Set owner
     *
     * @param \PFA\MainBundle\Entity\User $owner
     *
     * @return MailBox
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
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add email
     *
     * @param \PFA\MaillingBundle\Entity\Mail $email
     *
     * @return MailBox
     */
    public function addEmail(\PFA\MaillingBundle\Entity\Mail $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \PFA\MaillingBundle\Entity\Mail $email
     */
    public function removeEmail(\PFA\MaillingBundle\Entity\Mail $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
