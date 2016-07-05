<?php

namespace PFA\MaillingBundle\Controller;

use JMS\Serializer\SerializationContext;
use PFA\CoreBundle\Controller\MainController;
use PFA\MaillingBundle\Entity\Mail;
use PFA\MaillingBundle\Entity\MailAttachements;
use PFA\MaillingBundle\Entity\MailFolder;
use PFA\MaillingBundle\Form\MailFolderType;
use PFA\MaillingBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MaillingController extends MainController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="mailbox_home")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getEM();
        $folders = $this->get("pfa_mailling.managers.mail_folder_manager")->getUserFolders($this->getThisUser());
        $recievedMails = null;

        if(isset($folders[0])) {
            /** @var MailFolder $reception */
            $reception = $folders[0];
            $recievedMails = $em->getRepository("PFAMaillingBundle:Mail")->findBy(['receiver'=> $this->getThisUser()->getId(), "folder" => $reception->getId()]);
        }
        return $this->render('PFAMaillingBundle:Default:index2.html.twig',["folders" => $folders, "emails" => $recievedMails]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/loadData/{code}", name="load_folder_mail")
     */
    public function loadFolderMails(Request $request, $code)
    {
        $em = $this->getEM();

        $folder = $em->getRepository("PFAMaillingBundle:MailFolder")->findOneBy(['code' => $code]);
        $data = $em->getRepository("PFAMaillingBundle:Mail")->findBy(['mailBox'=> $this->getThisUser()->getMailBox(), "folder" => $folder->getId()]);

        return $this->render("PFAMaillingBundle:partials:mail_list.html.twig", ["data" => $data]);
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
     * @return Response
     * @Route("/create_folder", name="create_mail_folder")
     */
    public function createFolderAction(Request $request)
    {
        $em = $this->getEM();
        $form = $this->createForm(new MailFolderType());
        $form->handleRequest($request);

        if($form->isValid()) {
            /** @var MailFolder $mailFolder */
            $mailFolder = $form->getData();

            $mailFolder->setOwner($this->getThisUser());

            if ($em->getRepository("PFAMaillingBundle:MailFolder")->findOneBy(['name' => $mailFolder->getName(), "owner" => $this->getThisUser()])) {
                return new JsonResponse(['status' => false,"msg" => "Ce dossier existe déja !!!"]);
            }

            $mailFolder->setCode(strtoupper(str_replace(" ", "_", $mailFolder->getName())));
            $mailFolder->setIcon("folder");
            $mailFolder->setCanBeRemoved(true);

            $em->persist($mailFolder);
            $em->flush();

            return new JsonResponse(['status' => true,"msg" => "Dossier créer avec success !!!"]);
        }

        return $this->render("PFAMaillingBundle:Default:create_folder.html.twig", ['form' => $form->createView()]);
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
        $em = $this->getEM();
        $form = $this->createForm(new MailType());
        $form->handleRequest($request);

        if($form->isValid()) {

            $attachements = $form->get("attachements")->getData();
            /** @var UploadedFile $file */
            foreach ($attachements as $f => $file) {
                if($file) {
                    $fileName = md5(uniqid()).".".$file->guessExtension();
                    $file->move($this->getParameter("attachements_tmp_dir"), $fileName);
                }
            }

            foreach ($request->request->get("recievers") as $key => $item) {
                $mail = new Mail();
                $mailData = $request->request->get("mail");
                $mail->setSubject($mailData["subject"]);
                $mail->setBody($mailData["body"]);
                $receiver = $em->getRepository("PFAMainBundle:User")->find($item);
                $mail->setReceiver($receiver);
                $mail->setSender($this->getThisUser());
                $mail->setDate(new \DateTime());
                $mail->setMailBox($this->getThisUser()->getMailBox());
                if($this->getThisUser()->getId() == $receiver->getId()) {
                    $mail->setFolder($this->get("pfa_core.managers.user_manager")->getFolderByCode($mail->getSender(), "BOITE_RECEPTION"));
                } else {
                    $mail->setFolder($this->get("pfa_core.managers.user_manager")->getFolderByCode($mail->getReceiver(), "ENVOYE"));
                }
                $mail->setIsRead(false);

                $finder = new Finder();
                $finder->files()->in($this->getParameter("attachements_tmp_dir"));

                /** @var SplFileInfo $file */
                foreach ($finder as  $file) {
                    if($file) {
                        $newFile = uniqid("ATT_"). '.' . $file->getExtension();
                        if (copy($file->getPathname(), $this->getParameter("attachements_dir")."/". $newFile))
                        {
                            $mail_attachement = new MailAttachements();
                            // $mail_attachement->setImageFile();
                            $mail_attachement->setUpdatedAt(new \DateTime());
                            $mail_attachement->setMail($mail);
                            $mail_attachement->setImageName($newFile);
                            $em->persist($mail_attachement);
                            //$em->flush();
                        }
                    }
                }
                $em->persist($mail);
                $this->get("pfa_mailling.managers.mail_manager")->sendNormalMail($this->getThisUser(), $receiver, $mail);
                //die;
            }
            $em->flush();

            $finder = new Finder();
            $finder->files()->in($this->getParameter("attachements_tmp_dir"));

            /** @var SplFileInfo $f */
            foreach ($finder as $f) {
                unlink($f->getPathname());
            }

            return new JsonResponse(["status" => true]);
        }

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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * @Route("/mark_read", name="marque_mail_as_read")
     */
    public function markAsReadAction(Request $request)
    {
        $em = $this->getEM();
        $ids = $request->request->get("ids");
        foreach ($ids as $key => $id) {
            $mail = $em->getRepository("PFAMaillingBundle:Mail")->find($id);

            if(!$mail) {
                throw new \Exception("Ce mail n'existe pas.");
            }

            $em = $this->getEM();

            $mail->setIsRead(true);
            $em->persist($mail);
        }
        $em->flush();
        return new JsonResponse(['status' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * @Route("/delete_mail", name="delete_email")
     */
    public function deleteMailAction(Request $request)
    {
        $em = $this->getEM();
        $ids = $request->request->get("ids");
        foreach ($ids as $key => $id) {
            $mail = $em->getRepository("PFAMaillingBundle:Mail")->find($id);

            if(!$mail) {
                throw new \Exception("Ce mail n'existe pas.");
            }

            $em = $this->getEM();

            $mail->setIsRead(true);
            $em->remove($mail);
        }
        $em->flush();
        return new JsonResponse(['status' => true]);
    }

    /**
     * @param Request $request
     * @param Mail $mail
     * @return Response
     * @Route("{mail}/view", name="view_mail")
     */
    public function viewMailAction(Request $request, $mail)
    {
        $em = $this->getEM();
        $mail = $em->getRepository("PFAMaillingBundle:Mail")->find($mail);

        if(!$mail) {
            //TODO 404
            die("PFFFFF");
        }

        if(!in_array($this->getThisUser()->getId(), [$mail->getSender()->getId(), $mail->getReceiver()->getId()])) {
            //TODO 404
            die("PFFFFF 2");
        }
        if(!$mail->getIsRead()) {
            $mail->setIsRead(true);
            $em->persist($mail);
            $em->flush();
        }
        $folders = $this->get("pfa_mailling.managers.mail_folder_manager")->getUserFolders($this->getThisUser());

        return $this->render("PFAMaillingBundle:partials:view_mail.html.twig", ["mail" => $mail, "folders" => $folders]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("{mail}/in/{folder}", name="change_folder")
     */
    public function changeMailFolderAction(Request $request, Mail $mail, MailFolder $folder)
    {
        if($mail && $folder && ($folder->getOwner()->getId() == $this->getThisUser()->getId()) )
        {
            $em = $this->getEM();
            $mail->setFolder($folder);
            $em->persist($mail);
            $em->flush();
            return new JsonResponse(['status' => true]);
        }
        return new JsonResponse(['status' => false]);
    }

    /**
     * @param Request $request
     * @param Mail $mail
     * @return Response
     * @Route("{mail}/answer", name="anwser_mail")
     */
    public function answerMailAction(Request $request, Mail $mail)
    {
        if(!$mail) {
            // TODO 404
            die("404");
        }

        $em = $this->getEM();
        $form = $this->createForm(new MailType(['is_answer' => true]));
        $form->handleRequest($request);

        if($form->isValid()) {
            $mailAnswer = new Mail();
            $mailData = $request->request->get("mail");
            $mailAnswer->setSubject("Réponse à " . $mail->getSubject());
            $mailAnswer->setBody($mailData["body"]);
            $mailAnswer->setReceiver(null);
            $mailAnswer->setSender($this->getThisUser());
            $mailAnswer->setParent($mail);
            $mailAnswer->setDate(new \DateTime());
            $mailAnswer->setMailBox($mail->getMailBox());
            $mailAnswer->setFolder(null);
            $mailAnswer->setIsRead(true);

            $attachements = $form->get("attachements")->getData();
            /** @var UploadedFile $file */
            foreach ($attachements as $f => $file) {
                if($file) {
                    $fileName = md5(uniqid()).".".$file->guessExtension();
                    $file->move($this->getParameter("attachements_tmp_dir"), $fileName);
                }
            }

            $finder = new Finder();
            $finder->files()->in($this->getParameter("attachements_tmp_dir"));

            /** @var SplFileInfo $file */
            foreach ($finder as  $file) {
                if($file) {
                    $newFile = uniqid("ATT_"). '.' . $file->getExtension();
                    if (copy($file->getPathname(), $this->getParameter("attachements_dir")."/". $newFile))
                    {
                        $mail_attachement = new MailAttachements();
                        // $mail_attachement->setImageFile();
                        $mail_attachement->setUpdatedAt(new \DateTime());
                        $mail_attachement->setMail($mailAnswer);
                        $mail_attachement->setImageName($newFile);
                        $em->persist($mail_attachement);
                    }
                }
            }
            $em->persist($mailAnswer);

            $em->flush();

            /** @var SplFileInfo $f */
            foreach ($finder as $f) {
                unlink($f->getPathname());
            }

            return new JsonResponse(['status' => true]);
        }

        return $this->render("PFAMaillingBundle:partials:add_mail_answer.html.twig", ["mail" => $mail, "form" => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param Mail $mail
     * @return Response
     * @Route("{mail}/test", name="mail_test")
     */
    public function testAction(Request $request, Mail $mail) {
        $this->get("pfa_mailling.managers.mail_manager")->sendNormalMail($this->getThisUser(), $this->getThisUser(), $mail);
        return $this->render("PFAMaillingBundle:Default:test.html.twig");
    }
}
