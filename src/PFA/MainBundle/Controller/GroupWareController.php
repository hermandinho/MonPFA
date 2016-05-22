<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\MainBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\User\User;

class GroupWareController extends MainController
{
    /**
     * @Route("/xxl")
     */
    public function indexAction()
    {
        $form = $this->createForm(UserType::class);
        return $this->render('PFAMainBundle:Default:index.html.twig',["form" => $form->createView()]);
    }
}
