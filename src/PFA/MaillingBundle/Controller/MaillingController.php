<?php

namespace PFA\MaillingBundle\Controller;

use JMS\Serializer\SerializationContext;
use PFA\CoreBundle\Controller\MainController;
use PFA\MaillingBundle\Entity\Mail;
use PFA\MaillingBundle\Entity\MailFolder;
use PFA\MaillingBundle\Form\MailFolderType;
use PFA\MaillingBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MaillingController extends MainController
{
    /**
     * @Route("/", name="mailbox_home")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new MailType());
        $form->handleRequest($request);
        return $this->render('PFAMaillingBundle:Default:index.html.twig',["form" => $form->createView()]);
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
        $serializedFolders = $this->getSerializer()->serialize($folders, "json");

        //die(dump($folders));
        $data = [
            "folders" => json_decode($serializedFolders),
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

    /**
     * @param Request $request
     * @Route("/add_folder", name="add_mail_folder")
     * @return Response
     */
    public function addMailFolderAction(Request $request)
    {
        $myMailFolders = $this->get("pfa_mailling.managers.mail_folder_manager")->getUserFolders($this->getThisUser());
        $name = $request->request->get('name');
        $response = new Response();
        $found = false;

        /** @var MailFolder $myMailFolder */
        foreach ($myMailFolders as $key => $myMailFolder) {
            if(strtolower($myMailFolder->getName()) == strtolower($name)){
                $found = true;
            }
        }

        if($found){
            $response->setContent(json_encode(["status" => false, "message" => "Ce dossier existe déja."]));
        }else{
            $addFolder = new MailFolder();
            $addFolder->setName(ucwords($name))
                ->setIcon("folder")
                ->setCode(strtoupper(str_replace(" ", "_", $name)))
                ->setCanBeRemoved(true)
                ->setOwner($this->getThisUser());
            $em = $this->getEM();
            $em->persist($addFolder);
            $em->flush();

            $response->setContent(json_encode(["status" => true, "message" => "Dossier ajouté avec success !!!"]));
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/new_mail", name="send_new_mail")
     * @param Request $request
     * @return Response
     */
    public function sendMailAction(Request $request)
    {
        $form = $this->createForm(new MailType());
        $form->handleRequest($request);

        return $this->render("PFAMaillingBundle:partials:add_mail.html.twig", ["form" => $form->createView()]);
    }


    /**
     * @Route("/users/list/json", name="get_user_list_json")
     * @param Request $request
     * @return Response
     */
    public function getJsonUserListAction(Request $request)
    {
        $users = $this->get("pfa_core.managers.user_manager")->getUserList();
        //$users = $this->getEM()->getRepository("PFAMainBundle:User")->findBy([]);
        $serializerContext = SerializationContext::create()->setGroups(array('autocomplete'));
        $serializedData = $this->getSerializer()->serialize($users, "json",  $serializerContext);

        $response = new Response();
        $response->setContent(($serializedData));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
