<?php

namespace PFA\MainBundle\Controller;

use PFA\CoreBundle\Controller\MainController;
use PFA\CoreBundle\Entity\Forum;
use PFA\CoreBundle\Entity\ForumInteractionAnswer;
use PFA\CoreBundle\Entity\ForumInteractions;
use PFA\CoreBundle\Entity\Project;
use PFA\CoreBundle\Form\ForumInteractionAnswerType;
use PFA\CoreBundle\Form\ForumInteractionsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ForumController
 * @package PFA\MainBundle\Controller
 * @Route("/project/{project}/forum")
 */
class ForumController extends MainController
{
    /**
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="forum_home")
     */
    public function indexAction(Request $request, Project $project)
    {
        $data = $this->get("pfa_core.managers.forum_manager")->loadForum($project);

        return $this->render('PFAMainBundle:Forum:home.html.twig', ["forum" => $data, "project" => $project]);
    }

    /**
     * @param Request $request
     * @param Forum $forum
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{forum}/add_forum_interaction", name="add_forum_interaction")
     */
    public function addSubjectAction(Request $request, Forum $forum)
    {
        $form = $this->createForm(new ForumInteractionsType());
        $form->handleRequest($request);

        if($form->isValid()) {
            /** @var ForumInteractions $forumInteraction */
            $forumInteraction = $form->getData();
            $forumInteraction->setOwner($this->getThisUser());
            $forumInteraction->setForum($forum);
            $forumInteraction->setParent(null);
            $forumInteraction->setDate(new \DateTime());
            $em = $this->getEM();
            //die(dump($forumInteraction));
            $em->persist($forumInteraction);
            $em->flush();

            return new JsonResponse(["status" => true]);
        }

        return $this->render("PFAMainBundle:Forum:forum_interaction.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param ForumInteractions $interaction
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/{forum}/subject/{interaction}/view", name="view_forum_interaction")
     */
    public function viewSubjectAction(Request $request, ForumInteractions $interaction)
    {
        if(!$interaction) {
            throw new \Exception("<h1>Sujet Introuvable :( </h1>");
        }


        return $this->render('PFAMainBundle:Forum:subject_view.html.twig', ["interaction" => $interaction]);
    }

    /**
     * @param Request $request
     * @param ForumInteractions $interaction
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{forum}/subject/{interaction}/answer", name="answer_forum_interaction")
     */
    public function addSubjectAnswerAction(Request $request, ForumInteractions $interaction)
    {
        $form = $this->createForm(new ForumInteractionAnswerType());
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getEM();
            /** @var ForumInteractionAnswer $answer */
            $answer = $form->getData();
            $answer->setOwner($this->getThisUser());
            $answer->setForumInteraction($interaction);
            $answer->setDate(new \DateTime());

            $em->persist($answer);
            $em->flush();
            
            return new JsonResponse(["status" => true]);
        }

        return $this->render("PFAMainBundle:Forum:comment_forum_subject.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param ForumInteractions $interaction
     * @return JsonResponse
     * @Route("{interaction}/solved", name="interaction_solved")
     */
    public function markAsSolvedAction(Request $request, ForumInteractions $interaction)
    {
        $em = $this->getEM();

        if ($interaction) {
            $interaction->setStatus(true);
            $em->persist($interaction);
            $em->flush();

            return new JsonResponse(['status' => true]);
        }
        return new JsonResponse(['status' => false]);
    }
}
