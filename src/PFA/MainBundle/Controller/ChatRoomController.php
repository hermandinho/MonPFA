<?php

namespace PFA\MainBundle\Controller;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializationContext;
use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Entity\Project;
use PFA\MainBundle\Entity\ChatRoomMessages;
use PFA\MainBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ChatRoomController
 * @package PFA\MainBundle\Controller
 *
 * @Route("/project")
 * @Security("has_role('ROLE_USER')")
 */
class ChatRoomController extends MainController
{
    /**
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/{project}/chat", name="chat_room_home")
     */
    public function indexAction(Request $request, Project $project)
    {
        if(!$project){
            throw new \Exception("Le Projet #".$project->getId()." na pas été trouvé.");
        }

        $isProjectMember = $this->isProjectMember($this->getThisUser(), $project);

        if($isProjectMember){
            $projectMembers = $this->get("pfa_core.services.project_manager")->getProjetMembers($project);
            
            $chatMessages = $project->getChatRoom()->getChatRoomMessages();
            $serializerContext = SerializationContext::create()->setGroups(array('chat_message'));
            $serializedMessages = $this->getSerializer()->serialize($chatMessages,"json", $serializerContext);
            //die(dump($serializedMessages));

            return $this->render('PFAMainBundle:ChatRoom:index.html.twig', array(
                "project" => $project,
                "members" => $projectMembers,
                "chatMessages" => json_decode($serializedMessages)
            ));
        } else {
            return $this->render("PFAMainBundle:Projects:not_project_member.html.twig", ["project" => $project]);
        }
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return Response
     *
     * @Route("/{project}/chat_message", name="send_chat_message")
     */
    public function sendMessage(Request $request, Project $project)
    {
        /** @var EntityManager $em */
        $em = $this->getEM();

        $message = new ChatRoomMessages();
        $message->setChatRoom($project->getChatRoom())
                ->setIsRead(false)
                ->setDate(new \DateTime())
                ->setContent($request->request->get("message"))
                ->setSender($this->getThisUser());
        $em->persist($message);
        $em->flush();

        $serializerContext = SerializationContext::create()->setGroups(array('chat_message'));
        $serilized = $this->getSerializer()->serialize($message, "json", $serializerContext);

        return new JsonResponse(['status' => true, "message" => $serilized]);
    }
}
