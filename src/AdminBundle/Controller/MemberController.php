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
 * @Route("/members")
 */
class MemberController extends Controller
{
    /**
     * @Route("/list", name="_admin_members_list")
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $users = $this->get('doctrine')
            ->getRepository('AppBundle:Member')
            ->findAllOrdered($query->get('sort','m.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $query->get('page',1),
            10
        );

        return $this->render('AdminBundle:Member:list.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/{member}/delete", name="_admin_members_delete", options={"expose"=true})
     */
    public function deleteAction(Member $member){

        $em = $this->getDoctrine()->getManager();
        $em->remove($member);
        $em->flush();

        return new JsonResponse(array());
    }

}