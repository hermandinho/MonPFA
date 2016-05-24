<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\MainBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

/**
 * Class GroupWareController
 * @package PFA\MainBundle\Controller
 * @Route("/gw")
 * @Security("has_role('ROLE_USER')")
 */
class GroupWareController extends MainController
{
    /**
     * @Route("/o")
     */
    public function indexAction()
    {
        return $this->render("PFAMainBundle:GroupWare:index.html.twig");
    }
}
