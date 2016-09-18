<?php

namespace FrontofficeBundle\Controller;

use FrontofficeBundle\Entity\Contact;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use FrontofficeBundle\Entity\Member;
use FrontofficeBundle\Form\Type\MemberFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/member")
 */
class MemberController extends Controller
{
    /**
     * @Route("/create", name="_member_create")
     */
    public function createAction(Request $request){
        $member = new Member();
        $form = $this->createForm(new MemberFormType(), $member);

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
