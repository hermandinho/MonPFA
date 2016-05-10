<?php

namespace PFA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
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
     * @ORM\OneToOne(targetEntity="PFA\MaillingBundle\Entity\MailBox", inversedBy="owner", orphanRemoval=true)
     */
    private $mailBox;



    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
}
