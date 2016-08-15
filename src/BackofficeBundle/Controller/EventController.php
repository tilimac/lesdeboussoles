<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\EventType;
use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/new", name="_admin_event_new")
     * @Template()
     */
    public function newAction(Request $request){
        $event = new Event();

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{event}/edit", name="_admin_event_edit")
     * @Template()
     */
    public function editAction(Request $request, Event $event){
        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/list", name="_admin_event_list")
     * @Template()
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $hikes = $this->get('doctrine')
            ->getRepository('FrontofficeBundle:Event')
            ->findAllOrdered($query->get('sort','h.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hikes,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }
}
