<?php

namespace PFA\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forum
 *
 * @ORM\Table(name="forum")
 * @ORM\Entity(repositoryClass="PFA\CoreBundle\Repository\ForumRepository")
 */
class Forum
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
     * @ORM\OneToOne(targetEntity="PFA\CoreBundle\Entity\Project", mappedBy="forum", orphanRemoval=true)
     */
    private $project;

    /**
     * @var ForumInteractions
     *
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ForumInteractions", mappedBy="forum", cascade={"persist","remove"})
     */
    private $interactions;


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
     * @return Forum
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
        $this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add interaction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $interaction
     *
     * @return Forum
     */
    public function addInteraction(\PFA\CoreBundle\Entity\ForumInteractions $interaction)
    {
        $this->interactions[] = $interaction;

        return $this;
    }

    /**
     * Remove interaction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $interaction
     */
    public function removeInteraction(\PFA\CoreBundle\Entity\ForumInteractions $interaction)
    {
        $this->interactions->removeElement($interaction);
    }

    /**
     * Get interactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractions()
    {
        $x = $this->interactions->toArray();

        usort($x,  function ($a, $b)
        {
            if ($a->getDate() == $b->getDate()) {
                return 0;
            }
            return ($a->getDate() > $b->getDate()) ? -1 : 1;
        });
        return $x;
    }
}
