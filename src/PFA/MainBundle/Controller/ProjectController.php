<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render('PFAMainBundle:Project:project-list.html.twig');
    }
}
