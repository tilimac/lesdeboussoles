<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\EventType;
use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Contact;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/contacts")
 */
class ContactController extends Controller
{
    /**
     * @Route("/list", name="_admin_contacts_list")
     * @Template()
     */
    public function listAction(){
        $contactManager = $this->get('contact.manager');

        return array(
            'contacts' => $contactManager->getAll()
        );
    }

    /**
     * @Route("/{contact}/delete", name="_admin_contacts_delete")
     */
    public function deleteAction(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute('_admin_contacts_list');
    }
}
