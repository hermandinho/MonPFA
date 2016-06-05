<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 04/06/2016
 * Time: 23:28
 */

namespace PFA\MainBundle\Topics;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Client\ClientStorageInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class ChatRoomTopic implements TopicInterface
{

    /**
     * @var ClientManipulatorInterface
     */
    protected $clientManipulator;

    /**
     * @var ClientStorageInterface
     */
    protected $clientStorage;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ArrayCollection
     */
    private $userList;

    /**
     * ChatRoomTopic constructor.
     * @param ClientManipulatorInterface $clientManipulatorInterface
     * @param ClientStorageInterface $clientStorageInterface
     */
    public function __construct(ClientManipulatorInterface $clientManipulatorInterface, ClientStorageInterface $clientStorageInterface, EntityManager $entityManager)
    {
        $this->clientManipulator = $clientManipulatorInterface;
        $this->clientStorage = $clientStorageInterface;
        $this->em = $entityManager;
        $this->userList = new ArrayCollection();
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $user = $this->clientManipulator->getClient($connection);
        $topic->broadcast([
            'msg' => $connection->resourceId . " has joined " . $topic->getId()." : ".$user,
            "users" => count($topic),
            "type" => "subscribed"
        ]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $user = $this->clientManipulator->getClient($connection);

        $topic->broadcast(['msg' => $connection->resourceId . " has un subscribed from " . $topic->getId()." : ".$user, "users" => count($topic)]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param  array $exclude
     * @param  array $eligible
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        $topic->broadcast(["msg" => $event, "type" => "message"]);
    }

    /**
     * @return string
     */
    public function getName()
    {
       return "pfa.chatroom.topic";
    }
}