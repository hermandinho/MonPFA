<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 26/05/2016
 * Time: 21:35
 */

namespace PFA\CoreBundle\Managers;


use Doctrine\ORM\EntityManager;
use PFA\CoreBundle\Entity\Forum;
use PFA\CoreBundle\Entity\Project;
use PFA\CoreBundle\Entity\ShareZone;
use PFA\MaillingBundle\Entity\MailBox;
use PFA\MaillingBundle\Entity\MailFolder;
use PFA\MainBundle\Entity\Calender;
use PFA\MainBundle\Entity\ChatRoom;
use PFA\MainBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\Null;

class PFAManager
{
    /**
     * @var array
     */
    private $buildEntities = [];

    /**
     * @var array
     */
    private $insertEntities = [];

    /**
     * @var array
     */
    private $updateIntities = [];

    /**
     * @var TokenStorage
     */
    private $token;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->token = $tokenStorage;
    }

    /**
     * @param $entity
     */
    public function addEntityForInsertion($entity)
    {
        $this->insertEntities[] = [
            "entity" => $entity,
            "changeSet" => null
        ];
    }

    public function addEntityForUpdate($entity, $changeSets = [])
    {
        $this->insertEntities[] = [
            "entity" => $entity,
            "changeSet" => $changeSets
        ];
    }

    /**
     *
     */
    public function build()
    {
        foreach ($this->insertEntities as $entity) {
            $entity = $entity['entity'];
            switch ($entity){
                case $entity instanceof Project:
                    $this->handleOnNewProject($entity);
                    break;
                case $entity instanceof User:
                    $this->handleUserListener($entity);
                    break;
            }
        }
    }


    /**
     * @param User $user
     * @param array $changeSets
     */
    private function handleUserListener(User $user, $changeSets = [])
    {
        $calendar = new Calender();
        $calendar->setOwner($user);
        $this->addBuiltAction($calendar);

        $mailBox = new MailBox();
        $mailBox->setOwner($user);
        $this->addBuiltAction($mailBox);

        $mailFolder1 = new MailFolder();
        $mailFolder1->setOwner($user)
                    ->setCanBeRemoved(false)
                    ->setName("Boite de Reception")
                    ->setCode("BOITE_RECEPTION")
                    ->setIcon("recieved");
        $this->addBuiltAction($mailFolder1);

        $mailFolder2 = new MailFolder();
        $mailFolder2->setOwner($user)
            ->setCanBeRemoved(false)
            ->setName("Envoyé")
            ->setCode("ENVOYE")
            ->setIcon("sent");
        $this->addBuiltAction($mailFolder2);

    }

    /**
     * @param Project $project
     * @param array $changeSets
     */
    private function handleOnNewProject(Project $project, $changeSets = [])
    {
        $calendar = new Calender();
        //$calendar->setOwner($project->getOwner());
        $this->addBuiltAction($calendar);

        $shareZone = new ShareZone();
        //$shareZone->setProject($project);
        $this->addBuiltAction($shareZone);

        $forum = new Forum();
        //$forum->setProject($project);
        $this->addBuiltAction($forum);

        $chatRoom = new ChatRoom();
        $this->addBuiltAction($chatRoom);

        $project->setForum($forum)
                ->setRessources($shareZone)
                ->setChatRoom($chatRoom)
                ->setCalender($calendar)
                ->setCreatedAt(new \DateTime())
                ->setStatus("CREATED")
                ->setOwner($this->token->getToken()->getUser());

    }

    /**
     * @return array
     */
    public function getBuildEntities()
    {
        return $this->buildEntities;
    }

    private function addBuiltAction($entity)
    {
        $this->buildEntities[] = $entity;
    }

    public function clearBuilts()
    {
        $this->buildEntities = [];
    }

}