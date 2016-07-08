<?php

namespace PFA\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

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
     * 
     * @Groups({"chat_message"})
     */
    protected $id;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\ChatRoomMessages", inversedBy="chatRoom", cascade={"persist","remove"})
     */
    /*private $messages; */

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PFA\MainBundle\Entity\ChatRoomMessages", mappedBy="chatRoom")
     */
    private $chatRoomMessages;

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
     * Constructor
     */
    public function __construct()
    {
        $this->chatRoomMessages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add chatRoomMessage
     *
     * @param \PFA\MainBundle\Entity\ChatRoomMessages $chatRoomMessage
     *
     * @return ChatRoom
     */
    public function addChatRoomMessage(\PFA\MainBundle\Entity\ChatRoomMessages $chatRoomMessage)
    {
        $this->chatRoomMessages[] = $chatRoomMessage;

        return $this;
    }

    /**
     * Remove chatRoomMessage
     *
     * @param \PFA\MainBundle\Entity\ChatRoomMessages $chatRoomMessage
     */
    public function removeChatRoomMessage(\PFA\MainBundle\Entity\ChatRoomMessages $chatRoomMessage)
    {
        $this->chatRoomMessages->removeElement($chatRoomMessage);
    }

    /**
     * Get chatRoomMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChatRoomMessages()
    {
        return $this->chatRoomMessages;
    }

    function __toString()
    {
        return "Room #".$this->getId();
    }
}
