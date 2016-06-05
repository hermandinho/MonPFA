<?php

namespace PFA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * ChatRoomMessages
 *
 * @ORM\Table(name="chat_room_messages")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\ChatRoomMessagesRepository")
 */
class ChatRoomMessages
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
     * @var string
     * @Groups({"chat_message"})
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Groups({"chat_message"})
     */
    private $date;

    /**
     * @var ChatRoom
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\ChatRoom", cascade={"persist","remove"})
     */
    private $chatRoom;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=true)
     * @Groups({"chat_message"})
     */
    private $isRead;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")
     *
     * @Groups({"chat_message"})
     */
    private $sender;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id")
     *
     * @Groups({"chat_message"})
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
     * Set content
     *
     * @param string $content
     *
     * @return ChatRoomMessages
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ChatRoomMessages
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
     * Set chatRoom
     *
     * @param \PFA\MainBundle\Entity\ChatRoom $chatRoom
     *
     * @return ChatRoomMessages
     */
    public function setChatRoom(\PFA\MainBundle\Entity\ChatRoom $chatRoom = null)
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    /**
     * Get chatRoom
     *
     * @return \PFA\MainBundle\Entity\ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return ChatRoomMessages
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean
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
     * @return ChatRoomMessages
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
     * @return ChatRoomMessages
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
