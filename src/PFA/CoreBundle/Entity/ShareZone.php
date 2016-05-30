<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PFA\MainBundle\Entity\BaseEntity;

/**
 * ShareZone
 *
 * @ORM\Table(name="share_zone")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ShareZoneRepository")
 */
class ShareZone
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
     * @var Project
     *
     * @ORM\OneToOne(targetEntity="PFA\CoreBundle\Entity\Project", mappedBy="ressources", orphanRemoval=true)
     */
    private $project;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PFA\MainBundle\Entity\Documents", mappedBy="shareZone")
     */
    private $documents;


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
     * Set project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     *
     * @return ShareZone
     */
    public function setProject(\PFA\CoreBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \PFA\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add document
     *
     * @param \PFA\MainBundle\Entity\Documents $document
     *
     * @return ShareZone
     */
    public function addDocument(\PFA\MainBundle\Entity\Documents $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \PFA\MainBundle\Entity\Documents $document
     */
    public function removeDocument(\PFA\MainBundle\Entity\Documents $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }
}
