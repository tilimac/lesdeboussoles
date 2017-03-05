<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\EventType;
use AdminBundle\Form\Type\HikeType;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
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
