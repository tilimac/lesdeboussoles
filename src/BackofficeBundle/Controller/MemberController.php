<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\EventType;
use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use FrontofficeBundle\Entity\Member;
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
     * @Route("/list", name="_admin_member_list")
     * @Template()
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $members = $this->get('doctrine')
            ->getRepository('FrontofficeBundle:Member')
            ->findAllOrdered($query->get('sort','m.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $members,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/{member}/status", name="_admin_member_status", options={"expose"=true})
     */
    public function statusAction(Request $request, Member $member){
        $type   = $request->get('type', null);
        $status = $request->get('enabled', false) == "true" ? true : false;


        switch ($type) {
            case 'mail':
                $member->setMailVisible($status);
                break;
            case 'adress':
                $member->setAdressVisible($status);
                break;
            case 'phone':
                $member->setPhoneVisible($status);
                break;
           default:
               $member->setEnabled($status);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($member);
        $em->flush();

        return new JsonResponse(array());
    }

    /**
     * @Route("/{member}/detail", name="_admin_member_detail", options={"expose"=true})
     * @Template()
     */
    public function detailAction(Member $member){

        return array('member' => $member);
    }

    /**
     * @Route("/{member}/delete", name="_admin_member_delete", options={"expose"=true})
     */
    public function deleteAction(Member $member){

        $em = $this->getDoctrine()->getManager();
        $em->remove($member);
        $em->flush();

        return new JsonResponse(array());
    }
}
