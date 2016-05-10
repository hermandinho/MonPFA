<?php

namespace PFA\MaillingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="mailbox_home")
     */
    public function indexAction()
    {
        return $this->render('PFAMaillingBundle:Default:index.html.twig');
    }
}
