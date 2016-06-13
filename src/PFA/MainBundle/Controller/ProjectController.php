<?php

namespace PFA\MainBundle\Controller;

use Doctrine\ORM\EntityManager;
use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Entity\Project;
use PFA\CoreBundle\Entity\ProjectMember;
use PFA\CoreBundle\Form\ProjectType;
use PFA\MainBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $projectList = $this->get("pfa_core.services.project_manager")->getUserProjects($this->getThisUser());
        $serializedData = $this->getSerializer()->serialize($projectList, "json");
        return $this->render('PFAMainBundle:Projects:project-list.html.twig', ["projects" => $projectList]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/project/add", name="project_add")
     */
    public function addProject(Request $request)
    {
        $em = $this->getEM();
        $form = $this->createForm(new ProjectType());
        $form->handleRequest($request);
        //die(dump($request->query->all(), $form->isSubmitted()));
        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            $em->persist($project);

            $em->flush();

            return new JsonResponse(['status' => true]);
        }

        return $this->render("PFAMainBundle:Projects:add_projetcs.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/space", name="project_space_home")
     */
    public function projectSpaceAction(Request $request, Project $id)
    {
        $isProjectMember = $this->isProjectMember($this->getThisUser(), $id);
        if($isProjectMember){
            return $this->render("PFAMainBundle:Projects:project_space.html.twig", ["project" => $id]);
        } else {
            return $this->render("PFAMainBundle:Projects:not_project_member.html.twig", ["project" => $id]);
        }
    }

    /**
     * @param Request $request
     * @param Project $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/settings", name="project_settings")
     */
    public function projectConfiguration(Request $request, Project $id)
    {
        /** @var EntityManager $em */
        $em = $this->getEM();
        $projectForm = $this->createForm(new ProjectType(), $id);
        $projectForm->handleRequest($request);
        
        if($id->getOwner() != $this->getThisUser()){
            return $this->render("PFAMainBundle:Projects:not_project_member.html.twig", ["project" => $id]);
        }

        $memberAddForm = $this->createFormBuilder()
            ->add("member", null,array(
                "attr" => array(
                    "placeholder" => "Saisisseez l'address email du contact !!!",
                    "autocomplete" => "off"
                ),
                "label" => "Ajouter Un Membre"
            ))
            ->add("addBtn", SubmitType::class,array(
                'attr' => array(
                    "class" => "btn btn-primary ladda-button pull-right add-project-member-btn"
                ),
                "label" => "Ajouter"
            ))
            ->getForm();

        $memberAddForm->handleRequest($request);

        if($request->isMethod("POST")){
            if($projectForm->isSubmitted() && $projectForm->isValid()){
                $em->persist($id);
                $em->flush();
                return new JsonResponse(["status" => true]);
            }

            if($memberAddForm->isSubmitted() && $memberAddForm->isValid()){
                $data = $memberAddForm->getData();
                $member = $em->getRepository("PFAMainBundle:User")->findOneBy(["email" => $data['member']]);
                if($member){

                    $check = $em->getRepository("PFACoreBundle:ProjectMember")->findOneBy(['project' => $id, "memeber" => $member]);

                    if($check){
                        return new JsonResponse(['status' => false, "msg" => "Ce membre fait déjà parti de ce projet."]);
                    }

                    $projectMember = new ProjectMember();
                    $projectMember->setProject($id);
                    $projectMember->setMemeber($member);
                    $projectMember->setMemberType("INVITED");
                    $em->persist($projectMember);
                    $em->flush();
                    return new JsonResponse(["status" => true, "member" => $member]);
                } else {
                    return new JsonResponse(["status" => false,"msg" => "Aucun membre avec cette email <".$data['member']."> trouvé." ]);
                }
            }
        }

        $projectMembers = $this->get("pfa_core.services.project_manager")->getProjetMembers($id);

        return $this->render("PFAMainBundle:Projects:project_configuration.html.twig",
            [
                "project" => $id,
                "projectForm" => $projectForm->createView(),
                "addMemberForm" => $memberAddForm->createView(),
                "projectMembers" => $projectMembers
            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @Route("projectMember/{id}/remove", name="remove_project_memeber")
     */
    public function deleteProjectMember(Request $request, ProjectMember $id)
    {
        /** @var EntityManager $em */
        $em = $this->getEM();
        if($id){
            $em->remove($id);
            $em->flush();
            return new JsonResponse(['status' => true]);
        }
        return new JsonResponse(['status' => false]);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return Response
     *
     * @Route("/{project}/members/list", name="get_project_members_list")
     */
    public function loadProjectMembersListAction(Request $request, Project $project)
    {
        if($project){
            $projectMembers = $this->get("pfa_core.services.project_manager")->getProjetMembers($project);
            return $this->render("PFAMainBundle:Projects:partials/member-list-mini.html.twig", ["members" => $projectMembers, "project" => $project]);
        }
        return new Response("Projet Introuvable");
    }
}
