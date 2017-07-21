<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\EventType;
use AdminBundle\Form\Type\HikeType;
use AppBundle\Entity\Invitation;
use AppBundle\Entity\Member;
use AppBundle\Entity\User;
use AdminBundle\Form\Type\InvitationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/invitations")
 */
class InvitationController extends Controller
{
    /**
     * @Route("/{invitation}/delete", name="_admin_invitations_delete", options={"expose"=true})
     */
    public function deleteAction(Invitation $invitation){

        $em = $this->getDoctrine()->getManager();
        $em->remove($invitation);
        $em->flush();

        return new JsonResponse(array());
    }
}