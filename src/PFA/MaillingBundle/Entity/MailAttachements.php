<?php

namespace PFA\MaillingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * MailAttachements
 *
 * @ORM\Table(name="mail_attachements")
 * @ORM\Entity(repositoryClass="PFA\MaillingBundle\Repository\MailAttachementsRepository")
 * @Vich\Uploadable
 */
class MailAttachements
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
     * @var 
     * @ORM\ManyToOne(targetEntity="PFA\MaillingBundle\Entity\Mail", inversedBy="attachements")
     */
    private $mail;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="mail_attachements", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

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
     * Set mail
     *
     * @param \PFA\MaillingBundle\Entity\Mail $mail
     *
     * @return MailAttachements
     */
    public function setMail(\PFA\MaillingBundle\Entity\Mail $mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return \PFA\MaillingBundle\Entity\Mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return MailAttachements
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if($imageFile) {
            $this->setUpdatedAt(new \DateTime("now"));
        }
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MailAttachements
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
