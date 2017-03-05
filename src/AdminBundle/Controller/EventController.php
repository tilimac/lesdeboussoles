<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\EventType;
use AdminBundle\Form\Type\HikeType;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/new", name="_admin_events_new")
     * @Template()
     */
    public function newAction(Request $request){
        $event = new Event();

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $event->setImage('/web/uploads/randonnes'.$event->getImage());
            $em->persist($event);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{event}/edit", name="_admin_events_edit")
     * @Template()
     */
    public function editAction(Request $request, Event $event){
        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $event->setImage('/web/uploads/randonnes'.$event->getImage());
            $em->persist($event);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/list", name="_admin_events_list")
     * @Template()
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $hikes = $this->get('doctrine')
            ->getRepository('AppBundle:Event')
            ->findAllOrdered($query->get('sort','h.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hikes,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/{event}/delete", name="_admin_events_delete")
     */
    public function deleteHikesAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('_admin_events_list');
    }
}
