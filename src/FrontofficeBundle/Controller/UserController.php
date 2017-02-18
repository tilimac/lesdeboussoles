<?php

namespace FrontofficeBundle\Controller;

use FrontofficeBundle\Entity\Contact;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use FrontofficeBundle\Entity\Member;
use FrontofficeBundle\Form\Type\InvitationRequestFormType;
use FrontofficeBundle\Form\Type\MemberFormType;
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

        return $this->render('FrontofficeBundle:Member:create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
