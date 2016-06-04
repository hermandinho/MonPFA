<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Entity\Project;
use PFA\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

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

            return $this->render('PFAMainBundle:ChatRoom:index.html.twig', array("project" => $project, "members" => $projectMembers));
        } else {
            return $this->render("PFAMainBundle:Projects:not_project_member.html.twig", ["project" => $project]);
        }
    }
}
