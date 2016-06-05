<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 05/05/2016
 * Time: 12:03
 */

namespace PFA\MainBundle\RPC;


use Doctrine\ORM\EntityManager;
use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Ratchet\ConnectionInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PFAMainRPC implements RpcInterface
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TokenStorage
     */
    private $token;

    /**
     * PFAMainRPC constructor.
     * @param EntityManager $em
     * @param TokenStorage $token
     * @param ClientManipulatorInterface $clientManipulatorInterface
     */
    public function __construct(EntityManager $em, TokenStorage $token, ClientManipulatorInterface$clientManipulatorInterface)
    {
        $this->em = $em;
        $this->token = $token;
        $this->clientManipulator = $clientManipulatorInterface;
    }


    /**
     * @param ConnectionInterface $connectionInterface
     * @param WampRequest $wampRequest
     * @param $params
     * @return array
     */
    public function testFunc(ConnectionInterface $connectionInterface, WampRequest $wampRequest, $params)
    {
        return $connectionInterface->WAMP->clientStorageId;
        //return array("results" => array_sum($params));
    }


    /**
     * @param ConnectionInterface $connectionInterface
     * @param WampRequest $request
     * @param $params
     * @return false|string|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function subscribeFunc(ConnectionInterface $connectionInterface, WampRequest $request, $params)
    {
        $user = $this->clientManipulator->getClient($connectionInterface);
        return $user;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "pfa.main.rpc";
    }
}