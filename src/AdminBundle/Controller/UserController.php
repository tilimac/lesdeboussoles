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
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="_admin_users_list")
     */
    public function listAction(){
        $query = $this->get('request')->query;
        $users = $this->get('doctrine')
            ->getRepository('AppBundle:User')
            ->findAllOrdered($query->get('sort','u.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $query->get('page',1),
            10
        );

        return $this->render('AdminBundle:User:list.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/new", name="_admin_users_new")
     */
    public function newAction(Request $request){

        $invitation = new Invitation();
        $form = $this->createForm(new InvitationFormType(), $invitation);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Invitation envoyé avec succés')
            ;

            $urlRegistration = 'http://'.$request->getHttpHost().$this->get('router')->generate('fos_user_registration_register', array(
                    'code' => $invitation->getCode(),
                    'email' => $invitation->getEmail()
                ));
            $message = \Swift_Message::newInstance()
                ->setSubject('Invitation aux déboussolés')
                ->setFrom('monique.boschatel@gmail.com')
                ->setTo($invitation->getEmail())
                ->setBody(
                '<html>' .
                ' <head></head>' .
                ' <body>' .
                '  Bonjour, <br><br>' .
                '  Je vous invite à venir rejoindre les Déboussolés. Veuillez cliquer sur le lien ci-dessous pour vous inscrire.<br><br>' .
                '  <a href="'.$urlRegistration.'">'.$urlRegistration.'</a>' .
                ' </body>' .
                '</html>',
                'text/html'
            );
            $this->get('mailer')->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($invitation);
            $em->flush();
        }

        $query = $this->get('request')->query;
        $users = $this->get('doctrine')
            ->getRepository('AppBundle:Invitation')
            ->findAllOrdered($query->get('sort','i.code'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $query->get('page',1),
            10
        );

        return $this->render('AdminBundle:User:new.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/{user}/delete", name="_admin_users_delete", options={"expose"=true})
     */
    public function deleteAction(User $user){

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new JsonResponse(array());
    }

    /**
     * @Route("/{user}/detail", name="_admin_users_detail", options={"expose"=true})
     */
    public function detailAction(User $user){

        return $this->render('AdminBundle:User:list.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/{user}/status", name="_admin_users_status", options={"expose"=true})
     */
    public function statusAction(Request $request, User $user){
        $type   = $request->get('type', null);
        $status = $request->get('enabled', false) == "true" ? true : false;


        switch ($type) {
            case 'mail':
                $user->setMailVisible($status);
                break;
            case 'adress':
                $user->setAdressVisible($status);
                break;
            case 'phone':
                $user->setPhoneVisible($status);
                break;
            default:
                $user->setEnabled($status);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
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