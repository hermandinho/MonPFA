<?php

namespace PFA\MaillingBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\MaillingBundle\Entity\Mail;
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
        $mailBoxData = $this->get("pfa_mailling.managers.mail_box_manager")->getMailBoxData($this->getThisUser()->getMailBox());
        $serializedData = $this->getSerializer()->serialize($mailBoxData, "json");
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

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @internal param Mail $mail
     * @Route("/get_mail_children/{id}", name="get_mail_children")
     */
    public function getMailChildren(Request $request, $id)
    {
        $mail = $this->getDoctrine()->getManager()->getRepository("PFAMaillingBundle:Mail")->find($id);
        $serializedMail = $this->getSerializer()->serialize($mail, "json");
        $manager = $this->get("pfa_mailling.managers.mail_manager")->getMailChildren($mail);
        $serializedData = $this->getSerializer()->serialize($manager, "json");
        $response = new Response();

        $data = [
            "mail" => json_decode($serializedMail),
            "children" => json_decode($serializedData)
        ];

        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
