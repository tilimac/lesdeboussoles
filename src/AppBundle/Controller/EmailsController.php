<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
use AppBundle\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/emails")
 */
class EmailsController extends Controller
{

    /**
     * @Route("/unsubscribe", name="_emails_unsubscribe")
     * @Template()
     */
    public function unsubscribeAction()
    {
        return array(
        );
    }
    /**
     * @Route("/hikes/{hike}/postponed", name="_emails_hikes_postponed")
     * @Template()
     */
    public function postponedAction(Hike $hike)
    {


        return array(
            'hike' => $hike,
            'today' => new \DateTime('now')
        );
    }

}
