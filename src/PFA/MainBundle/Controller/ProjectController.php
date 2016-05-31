<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @package PFA\MainBundle\Controller
 * @Route("/project")
 * @Security("has_role('ROLE_USER')")
 */
class ProjectController extends MainController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $name
     * @Route("/", name="project_list_home_page")
     */
    public function indexAction(Request $request)
    {
        $projectList = $this->get("pfa_core.services.project_manager")->getUserProjects($this->getThisUser());
        $serializedData = $this->getSerializer()->serialize($projectList, "json");
        return $this->render('PFAMainBundle:Project:project-list.html.twig', ["projects" => $projectList]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/project/add", name="project_add")
     */
    public function addProject(Request $request)
    {
        $em = $this->getEM();
        $form = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        //die(dump($request->query->all(), $form->isSubmitted()));
        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            $em->persist($project);

            $em->flush();

            return new JsonResponse(['status' => true]);
        }

        return $this->render("PFAMainBundle:Projects:add_projetcs.html.twig", ['form' => $form->createView()]);
    }
}
