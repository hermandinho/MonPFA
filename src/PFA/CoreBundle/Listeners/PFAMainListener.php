<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 24/05/2016
 * Time: 23:33
 */

namespace PFA\CoreBundle\Listeners;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PFAMainListener implements EventSubscriberInterface
{

    /**
     * @param LifecycleEventArgs $args
     * @ORM\PrePersist()
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        //die(dump($args->getEntity()));
    }

    public function onFlush()
    {
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array("prePersist","onFlush");
    }

}