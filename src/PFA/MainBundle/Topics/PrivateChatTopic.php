<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 11/06/2016
 * Time: 16:34
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

class PrivateChatTopic implements TopicInterface
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
            'msg' => $user . "(#" . $connection->resourceId . ") has joined " . $topic->getId(),
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
        $topic->broadcast([
            'msg' => $user . "(#" . $connection->resourceId . ") has unsubscribed from  " . $topic->getId(),
            "users" => count($topic),
            "type" => "subscribed"
        ]);
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
        $topic->broadcast(["msg" => $event, "type" => "message"], [$connection->WAMP->sessionId]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "pfa.private_chat.topic";
    }
}