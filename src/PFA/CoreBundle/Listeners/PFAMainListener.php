<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 24/05/2016
 * Time: 23:33
 */

namespace PFA\CoreBundle\Listeners;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use PFA\CoreBundle\Entity\Project;
use PFA\CoreBundle\Managers\PFAManager;
use PFA\MaillingBundle\Entity\MailFolder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PFAMainListener implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $persistedEntities = [];

    /**
     * @var array
     */
    private $persistedMailFolders = [];

    /**
     * @var PFAManager
     */
    private $pfaManager;

    /**
     * @var array
     */
    private $observedEntities = [];

    /**
     * PFAMainListener constructor.
     * @param PFAManager $pfaManager
     */
    public function __construct(PFAManager $pfaManager)
    {
        $this->pfaManager = $pfaManager;
        $this->observedEntities = [
            "User",
            "Project"
        ];
    }

    /**
     * @param OnFlushEventArgs $eventArgs
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $nameSpace = get_class($entity);
            $exploded = explode("\\", $nameSpace);
            $className = end($exploded);

            if(in_array($className, $this->observedEntities)){
                $this->pfaManager->addEntityForInsertion($entity);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $nameSpace = get_class($entity);
            $exploded = explode("\\", $nameSpace);
            $className = end($exploded);
            if(in_array($className, $this->observedEntities)){
                $this->pfaManager->addEntityForUpdate($entity, $uow->getEntityChangeSet($entity));
            }
        }

        $this->pfaManager->build();

        //die(dump($this->pfaManager->getBuildEntities()));
        foreach ($this->pfaManager->getBuildEntities() as $entity) {
            $meta = $em->getClassMetadata(get_class($entity));
            if($entity instanceof MailFolder) {
                if(!in_array($entity->getName(), $this->persistedMailFolders)){
                    $em->persist($entity);
                    $this->persistedMailFolders[] = $entity->getName();
                }
            } elseif ($entity instanceof Project){
                if(!in_array(get_class($entity), $this->persistedEntities)){
                    $uow->recomputeSingleEntityChangeSet($meta, $entity);
                }
            }
            else {
                if(!in_array(get_class($entity), $this->persistedEntities)){
                    $em->persist($entity);
                    $this->persistedEntities[] = get_class($entity);
                }
            }
        }

        $uow->computeChangeSets();
        $this->pfaManager->clearBuilts();
        $this->persistedEntities = [];
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
        return array("onFlush");
    }

}