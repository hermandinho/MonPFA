<?php

namespace PFA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PFA\CoreBundle\Entity\ShareZone;

/**
 * Documents
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\DocumentsRepository")
 */
class Documents extends BaseEntity
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="extention", type="string", length=10, nullable=true)
     */
    private $extention;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=10, nullable=true)
     */
    private $version;

    /**
     * @var Documents
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var ShareZone
     * @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\ShareZone", inversedBy="documents")
     */
    private $shareZone;


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
     * Set title
     *
     * @param string $title
     *
     * @return Documents
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Documents
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set extention
     *
     * @param string $extention
     *
     * @return Documents
     */
    public function setExtention($extention)
    {
        $this->extention = $extention;

        return $this;
    }

    /**
     * Get extention
     *
     * @return string
     */
    public function getExtention()
    {
        return $this->extention;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Documents
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return Documents
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set shareZone
     *
     * @param \PFA\CoreBundle\Entity\ShareZone $shareZone
     *
     * @return Documents
     */
    public function setShareZone(\PFA\CoreBundle\Entity\ShareZone $shareZone = null)
    {
        $this->shareZone = $shareZone;

        return $this;
    }

    /**
     * Get shareZone
     *
     * @return \PFA\CoreBundle\Entity\ShareZone
     */
    public function getShareZone()
    {
        return $this->shareZone;
    }
}
