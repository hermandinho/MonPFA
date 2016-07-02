<?php

namespace PFA\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as Serializer;
use PFA\CoreBundle\Entity\ForumInteractions;
use PFA\MaillingBundle\Entity\MailBox;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="PFA\MainBundle\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var int
     * @Groups({"autocomplete", "chat_message", "mail_box"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Groups({"autocomplete", "chat_message", "mail_box"})
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(name="genre", type="string", length=255, nullable=true)
     */
    protected $genre;

    /**
     * @var string
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    protected $tel;

    /**
     * @var string
     * @Groups({"autocomplete", "chat_message", "mail_box"})
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var MailBox
     * @ORM\OneToOne(targetEntity="PFA\MaillingBundle\Entity\MailBox", mappedBy="owner", orphanRemoval=true)
     */
    private $mailBox;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ForumInteractions", mappedBy="owner")
     */
    private $forumInteraction;

    /**
     * @var Calender
     *
     * @ORM\OneToOne(targetEntity="PFA\MainBundle\Entity\Calender", mappedBy="owner", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $calender;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\Project", mappedBy="owner", orphanRemoval=true)
     */
    private $projects;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ProjectMember", mappedBy="memeber")
     */
    private $projectsInvitedIn;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\MainBundle\Entity\Documents", mappedBy="owner", orphanRemoval=true)
     */
    private $documents;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="profile_image", fileNameProperty="imageName")
     *
     * @var File
     * @Groups({"chat_message"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     *  @Groups({"chat_message"})
     */
    private $imageName;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PFA\CoreBundle\Entity\ForumInteractionAnswer", mappedBy="owner", orphanRemoval=true, cascade={"persist"})
     */
    private $forumAnswers;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->projects = new ArrayCollection();
        $this->projectsInvitedIn = new ArrayCollection();
        $this->forumAnswers = new ArrayCollection();
        $this->forumInteraction = new ArrayCollection();
        $this->addRole('ROLE_USER');
        $this->setEnabled(true);
        $this->documents = new ArrayCollection();
    }


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
     * Set mailBox
     *
     * @param \PFA\MaillingBundle\Entity\MailBox $mailBox
     *
     * @return User
     */
    public function setMailBox(\PFA\MaillingBundle\Entity\MailBox $mailBox = null)
    {
        $this->mailBox = $mailBox;

        return $this;
    }

    /**
     * Get mailBox
     *
     * @return \PFA\MaillingBundle\Entity\MailBox
     */
    public function getMailBox()
    {
        return $this->mailBox;
    }

    /**
     * Set forumInteraction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $forumInteraction
     *
     * @return User
     */
    public function setForumInteraction(\PFA\CoreBundle\Entity\ForumInteractions $forumInteraction = null)
    {
        $this->forumInteraction = $forumInteraction;

        return $this;
    }

    /**
     * Get forumInteraction
     *
     * @return \PFA\CoreBundle\Entity\ForumInteractions
     */
    public function getForumInteraction()
    {
        return $this->forumInteraction;
    }

    /**
     * Set calender
     *
     * @param \PFA\MainBundle\Entity\Calender $calender
     *
     * @return User
     */
    public function setCalender(\PFA\MainBundle\Entity\Calender $calender = null)
    {
        $this->calender = $calender;

        return $this;
    }

    /**
     * Get calender
     *
     * @return \PFA\MainBundle\Entity\Calender
     */
    public function getCalender()
    {
        return $this->calender;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Add project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     *
     * @return User
     */
    public function addProject(\PFA\CoreBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \PFA\CoreBundle\Entity\Project $project
     */
    public function removeProject(\PFA\CoreBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add projectsInvitedIn
     *
     * @param \PFA\CoreBundle\Entity\Project $projectsInvitedIn
     *
     * @return User
     */
    public function addProjectsInvitedIn(\PFA\CoreBundle\Entity\Project $projectsInvitedIn)
    {
        $this->projectsInvitedIn[] = $projectsInvitedIn;

        return $this;
    }

    /**
     * Remove projectsInvitedIn
     *
     * @param \PFA\CoreBundle\Entity\Project $projectsInvitedIn
     */
    public function removeProjectsInvitedIn(\PFA\CoreBundle\Entity\Project $projectsInvitedIn)
    {
        $this->projectsInvitedIn->removeElement($projectsInvitedIn);
    }

    /**
     * Get projectsInvitedIn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectsInvitedIn()
    {
        return $this->projectsInvitedIn;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return User
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Add document
     *
     * @param \PFA\MainBundle\Entity\Documents $document
     *
     * @return User
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

    /**
     * Add forumInteraction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $forumInteraction
     *
     * @return User
     */
    public function addForumInteraction(\PFA\CoreBundle\Entity\ForumInteractions $forumInteraction)
    {
        $this->forumInteraction[] = $forumInteraction;

        return $this;
    }

    /**
     * Remove forumInteraction
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractions $forumInteraction
     */
    public function removeForumInteraction(\PFA\CoreBundle\Entity\ForumInteractions $forumInteraction)
    {
        $this->forumInteraction->removeElement($forumInteraction);
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
            $this->setLastLogin(new \DateTime("now"));
        }
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return User
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
     * Add forumAnswer
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractionAnswer $forumAnswer
     *
     * @return User
     */
    public function addForumAnswer(\PFA\CoreBundle\Entity\ForumInteractionAnswer $forumAnswer)
    {
        $this->forumAnswers[] = $forumAnswer;

        return $this;
    }

    /**
     * Remove forumAnswer
     *
     * @param \PFA\CoreBundle\Entity\ForumInteractionAnswer $forumAnswer
     */
    public function removeForumAnswer(\PFA\CoreBundle\Entity\ForumInteractionAnswer $forumAnswer)
    {
        $this->forumAnswers->removeElement($forumAnswer);
    }

    /**
     * Get forumAnswers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForumAnswers()
    {
        return $this->forumAnswers;
    }


    public function __toString()
    {
        return $this->getNom() . " " . $this->getPrenom() . "( " . $this->getEmail() . " ) ";
    }
}
