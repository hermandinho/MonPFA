<?php

namespace PFA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageAttachments
 *
 * @ORM\Table(name="message_attachments")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\MessageAttachmentsRepository")
 */
class MessageAttachments extends BaseEntity
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
     * @var Documents
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Documents", cascade={"persist"})
     */
    private $document;

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
     * Set document
     *
     * @param \PFA\MainBundle\Entity\Documents $document
     *
     * @return MessageAttachments
     */
    public function setDocument(\PFA\MainBundle\Entity\Documents $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \PFA\MainBundle\Entity\Documents
     */
    public function getDocument()
    {
        return $this->document;
    }
}
