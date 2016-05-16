<?php

namespace PFA\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends MainController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $serializedData = $this->getSerializer()->serialize($this->getThisUser()->getMailBox(), "json");
        return $this->render('PFACoreBundle:Default:index.html.twig', ["data" => $serializedData]);
    }
}
