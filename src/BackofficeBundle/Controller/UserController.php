<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\EventType;
use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use FrontofficeBundle\Entity\Member;
use FrontofficeBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="_admin_user_list")
     * @Template()
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $users = $this->get('doctrine')
            ->getRepository('FrontofficeBundle:User')
            ->findAllOrdered($query->get('sort','u.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/{user}/delete", name="_admin_user_delete", options={"expose"=true})
     */
    public function deleteAction(User $user){

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new JsonResponse(array());
    }

    /**
     * @Route("/{user}/switch", name="_admin_user_switch", options={"expose"=true})
     */
    public function switchAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();
        $user->setRoles(array($request->get('role')));
        $em->persist($user);
        $em->flush();

        return new JsonResponse(array());
    }
}
