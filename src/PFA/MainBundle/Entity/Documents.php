<?php

namespace PFA\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use PFA\CoreBundle\Entity\ShareZone;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Documents
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\DocumentsRepository")
 *  @Vich\Uploadable
 */
class Documents
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="version", type="integer", nullable=true)
     */
    private $version;

    /**
     * @var Documents
     *
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\Documents", inversedBy="version")
     * @JoinColumn(name="parent", referencedColumnName="id",onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var ShareZone
     * @ORM\ManyToOne(targetEntity="PFA\CoreBundle\Entity\ShareZone", inversedBy="documents")
     */
    private $shareZone;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="project_ressoucces", fileNameProperty="imageName")
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
     * @var
     * @ORM\ManyToOne(targetEntity="PFA\MainBundle\Entity\User", inversedBy="documents")
     */
    private $owner;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MainBundle\Entity\Documents", mappedBy="parent", cascade={"remove"})
     */
    private $versions;

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
     * @param Documents $parent
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
     * @return Documents
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

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Documents
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
     * @param File $imageFile
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
     * @return Documents
     */
    public function setUpdatedAt(\DateTime $updatedAt)
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Documents
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set owner
     *
     * @param \PFA\MainBundle\Entity\User $owner
     *
     * @return Documents
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
        $this->versions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add version
     *
     * @param \PFA\MainBundle\Entity\Documents $version
     *
     * @return Documents
     */
    public function addVersion(\PFA\MainBundle\Entity\Documents $version)
    {
        $this->versions[] = $version;

        return $this;
    }

    /**
     * Remove version
     *
     * @param \PFA\MainBundle\Entity\Documents $version
     */
    public function removeVersion(\PFA\MainBundle\Entity\Documents $version)
    {
        $this->versions->removeElement($version);
    }

    /**
     * Get versions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVersions()
    {
        return $this->versions;
    }
}
