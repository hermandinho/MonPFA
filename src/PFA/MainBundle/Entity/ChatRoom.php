<?php

namespace PFA\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ChatRoom
 *
 * @ORM\Table(name="chat_room")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\ChatRoomRepository")
 */
class ChatRoom
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
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\ChatRoomMessages", inversedBy="chatRoom", cascade={"persist","remove"})
     */
    /*private $messages; */


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
