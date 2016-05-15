<?php

namespace PFA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calender
 *
 * @ORM\Table(name="calender")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\CalenderRepository")
 */
class Calender extends BaseEntity
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
