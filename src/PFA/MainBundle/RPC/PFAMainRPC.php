<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 05/05/2016
 * Time: 12:03
 */

namespace PFA\MainBundle\RPC;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Ratchet\ConnectionInterface;

class PFAMainRPC implements RpcInterface
{

    /**
     * @param ConnectionInterface $connectionInterface
     * @param WampRequest $wampRequest
     * @param $params
     * @return array
     */
    public function testFunc(ConnectionInterface $connectionInterface, WampRequest $wampRequest, $params)
    {
        return $connectionInterface->WAMP->clientStorageId;
        return array("results" => array_sum($params));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return "pfa.main.rpc";
    }
}