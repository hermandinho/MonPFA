<?php

namespace PFA\MaillingBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MaillingController extends MainController
{
    /**
     * @Route("/", name="mailbox_home")
     */
    public function indexAction()
    {
        return $this->render('PFAMaillingBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/data", name="mail_box_data")
     * @return mixed
     */
    public function getMailData(Request $request)
    {
        $response = new Response();
        $serializedData = $this->getSerializer()->serialize($this->getThisUser()->getMailBox(), "json");
        $folders = $this->get("pfa_mailling.managers.mail_folder_manager")->getUserFolders($this->getThisUser());

        //die(dump($folders));
        $data = [
            "folders" => $folders,
            "mailbox" => json_decode($serializedData)
        ];
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
