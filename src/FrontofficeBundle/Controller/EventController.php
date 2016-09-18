<?php

namespace FrontofficeBundle\Controller;

use FrontofficeBundle\Entity\Contact;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/{event}/show", name="_event_show")
     */
    public function showAction(Event $event){
        return $this->render('FrontofficeBundle:Event:show.html.twig', array(
            'event' => $event
        ));
    }
}
