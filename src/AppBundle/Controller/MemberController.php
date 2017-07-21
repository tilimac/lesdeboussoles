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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/members")
 */
class MemberController extends Controller
{
    /**
     * @Route("/{member}/delete", name="_members_delete", options={"expose"=true})
     */
    public function deleteAction(Member $member)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($member);
        $em->flush();

        return $this->redirectToRoute('fos_user_profile_edit');
    }
}
