<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;
use PFA\MainBundle\Entity\User;

/**
 * MailBox
 *
 * @ORM\Table(name="mail_box")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailBoxRepository")
 */
class MailBox extends BaseEntity
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
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\User", mappedBy="mailBox")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;


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
}
