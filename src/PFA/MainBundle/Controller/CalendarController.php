<?php
/**
 * Created by PhpStorm.
 * User: El-PC
 * Date: 21/05/2016
 * Time: 15:53
 */

namespace PFA\MainBundle\Controller;


use PFA\CoreBundle\Controller\MainController;
use PFA\MainBundle\Entity\CalenderEvents;
use PFA\MainBundle\Form\CalenderEventsType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends MainController
{

    /**
     * @Route("/agenda", name="agenda_home")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $calenerEvents = new CalenderEvents();
        $form = $this->createForm(new CalenderEventsType(), $calenerEvents);
        $form->handleRequest($request);
        $validator = $this->get("validator");
        if($form->isValid()){
            //die(dump($form->isValid()));
            /** @var CalenderEvents $calenerEvents */
            $calenerEvents = $form->getData();
            $calenerEvents->setCalender($this->getThisUser()->getCalender());

            //die(dump($calenerEvents, $form->isValid(), $form->getErrors(true)));
            $em = $this->getEM();
            $em->persist($calenerEvents);
            $em->flush();
            return new JsonResponse(["status" => true]);
        }
        return $this->render("PFAMainBundle:Angenda:index.html.twig", ['form' => $form->createView(), "include" => "add_event"]);
    }

    /**
     * @Route("/agenda/get/events", name="agenda_get_events")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addEventAction(Request $request)
    {
        $serializer = $this->getSerializer()->serialize($this->getThisUser()->getCalender()->getEvents(),"json");
        $response = new Response();
        $response->setContent(($serializer));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/agenda/events/{id}/edit", name="agenda_edit_event")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editEventAction(Request $request, $id)
    {
        $em = $this->getEM();
        $calendarEvent = $em->getRepository("PFAMainBundle:CalenderEvents")->find($id);

        if($calendarEvent){
            $form = $this->createForm(new CalenderEventsType(), $calendarEvent);
            $form->handleRequest($request);

            if($form->isValid()){
                $em->persist($calendarEvent);
                $em->flush();

                return new JsonResponse(['status' => true]);
            }

            return $this->render("PFAMainBundle:Angenda:edit_event.html.twig", ['form' => $form->createView(), "include" => "edit_event", "eventId" => $calendarEvent->getId()]);
        }
    }
}