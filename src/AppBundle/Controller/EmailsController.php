<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Event;
use AppBundle\Entity\Hike;
use AppBundle\Entity\Invitation;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/emails")
 */
class EmailsController extends Controller
{

    /**
     * @Route("/unsubscribe/{user}/{email}", name="_emails_unsubscribe")
     * @Template()
     */
    public function unsubscribeAction(User $user, $email)
    {
        if($user->getEmail() == $email){
            $user->setEmailNewsletter(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $message = "Vous êtes désabonné de la newsletter";
        }
        else{
            $message = "Une erreur s'est produite, veuillez nous envoyer votre demande à l'adresse suivante : <a href='mailto:monique.boschatel@gmail.com'>monique.boschatel@gmail.com</a>";
        }

        return array(
            'message' => $message
        );
    }

    /**
     * @Route("/hikes/{hike}/postponed/user/{user}", name="_emails_hikes_postponed")
     * @Template()
     */
    public function postponedAction(Hike $hike, User $user)
    {
        return array(
            'hike' => $hike,
            'user' => $user
        );
    }

    /**
     * @Route("/newsletters/{newsletter}/user/{user}", name="_emails_newsletters")
     * @Template()
     */
    public function newsletterAction(Newsletter $newsletter, User $user)
    {
        return array(
            'newsletter' => $newsletter,
            'user' => $user
        );
    }

    /**
     * @Route("/test", name="_emails_test")
     * @Template()
     */
    public function testAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello , it\'s a test')
            ->setFrom('monique.boschatel@gmail.com')
            ->setTo('tilimac@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        var_dump($this->get('mailer')->send($message));

        return new Response();
    }

}
