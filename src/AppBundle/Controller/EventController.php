<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
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
        return $this->render('AppBundle:Event:show.html.twig', array(
            'event' => $event
        ));
    }
}
