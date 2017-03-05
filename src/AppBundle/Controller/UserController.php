<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
use AppBundle\Entity\Member;
use AppBundle\Form\Type\InvitationRequestFormType;
use AppBundle\Form\Type\MemberFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/invitation/request", name="_users_invitation_request")
     */
    public function invitationRequestAction(Request $request){


        $member = new Member();
        $form = $this->createForm(new InvitationRequestFormType(), $member);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Vous êtes maintenant inscrit au randonnées. Si vous ne l\'avez pas encore fait, n\'oubliez psa de ramener un certificat médicale.')
            ;

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
        }

        return $this->render('AppBundle:Member:create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
