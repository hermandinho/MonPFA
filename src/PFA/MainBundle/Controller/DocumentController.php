<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Entity\Project;
use PFA\MainBundle\Entity\Documents;
use PFA\MainBundle\Form\DocumentsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DocumentController
 * @package PFA\MainBundle\Controller
 * @Route("/project/{project}/documents")
 * @Security("has_role('ROLE_USER')")
 */
class DocumentController extends MainController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="project_documents_home")
     */
    public function indexAction(Request $request, Project $project)
    {
        $documents = $this->get("pfa_mailling.managers.documents_manager")->getMainDocuments($project);
        return $this->render('PFAMainBundle:Documents:index.html.twig', ['project' => $project, "documents" => $documents]);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="upload_project_document")
     */
    public function addDocumentAction(Request $request, Project $project)
    {
        $doc = new Documents();
        $em = $this->getEM();
        $form = $this->createForm(new DocumentsType());
        $form->handleRequest($request);

        if($form->isValid()) {
            /** @var Documents $doc */
            $doc = $form->getData();
            $doc->setShareZone($project->getRessources());
            $doc->setUpdatedAt(new \DateTime());
            $doc->setOwner($this->getThisUser());
            if($request->request->has("docType")) {
                $type = $request->request->get("docType");

                switch ($type) {
                    case "parent":
                        $doc->setVersion(1);break;
                    case "child":
                        $parent = $em->getRepository("PFAMainBundle:Documents")->find($request->request->get("docParent"));
                        $doc->setVersion($this->get("pfa_mailling.managers.documents_manager")->doDocChildVersion($parent) + 1);
                        $doc->setParent($parent);
                        //die(dump($doc->getParent()->getId()));
                        break;
                }
            }

            //die(dump($request->request->get("docParent")));

            $em->persist($doc);
            $em->flush();
            return new JsonResponse(['status' => true]);
        }

        return $this->render("PFAMainBundle:Documents:add_document.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param Documents $document
     * @return JsonResponse
     * @Route("/{document}/delete", name="pfa_delete_document")
     */
    public function deleteDocumentAction(Request $request, Documents $document)
    {
        $em = $this->getEM();
        $json = [];

        if($document) {
            $em->remove($document);
            $em->flush();
            $json["status"] = true;
            $json["msg"] = "Document Retirer avec success.";
        }

        return new JsonResponse($json);
    }
}
