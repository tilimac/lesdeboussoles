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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/emails")
 */
class EmailsController extends Controller
{

    /**
     * @Route("/unsubscribe/{type}/{user}/{email}", name="_emails_unsubscribe")
     * @Template()
     */
    public function unsubscribeAction($type, User $user, $email)
    {
        if($user->getEmail() == $email){
            if($type == 'newsletter'){
                $user->setEmailNewsletter(0);
                $message = "Vous êtes désabonné des mails d'information général.";
            }
            elseif($type == 'hike'){
                $user->setEmailHike(0);
                $message = "Vous êtes désabonné des mails d'information sur les randonées.";
            }
            else{
                return array('message' => "Une erreur s'est produite, veuillez nous envoyer votre demande à l'adresse suivante : <a href='mailto:monique.boschatel@gmail.com'>monique.boschatel@gmail.com</a>");
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return array('message' => $message);
        }
        else{
            return array('message' => "Une erreur s'est produite, veuillez nous envoyer votre demande à l'adresse suivante : <a href='mailto:monique.boschatel@gmail.com'>monique.boschatel@gmail.com</a>");
        }
    }

    /**
     * @Route("/hikes/{hike}/postponed/user/{user}", name="_emails_hikes_postponed")
     * @Template()
     */
    public function hikesPostponedAction(Hike $hike, User $user)
    {
        return array(
            'hike' => $hike,
            'user' => $user
        );
    }

    /**
     * @Route("/hikes/{hike}/removed/user/{user}", name="_emails_hikes_removed")
     * @Template()
     */
    public function hikesRemovedAction(Hike $hike, User $user)
    {
        return array(
            'hike' => $hike,
            'user' => $user
        );
    }

    /**
     * @Route("/newsletters/{newsletter}/user/{user}/{email}", name="_emails_newsletters")
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
     * @Route("/hikes/{hike}/remimder/{user}/{email}", name="_emails_hikes_reminder")
     * @Template()
     */
    public function hikesRemimderAction(Request $request, Hike $hike, User $user, $email)
    {
        return array(
            'hike' => $hike,
            'email' => $email,
            'user' => $user
        );
    }

    /**
     * @Route("/hikes/remimder/sender", name="_emails_hikes_reminder_sender")
     */
    public function hikesRemimderSenderAction()
    {
        $hikeManager = $this->get('hike.manager');
        /* @var Hike $nextHike */
        $nextHike = $hikeManager->getNextHikes(1);
        //$nextHike = empty($nextHikes) ? NULL : $nextHikes[0];

        $datecheck = new \DateTime();
        $datecheck->add(new \DateInterval('P3D'));

        /*var_dump($datecheck->format('Y-m-d'));
        var_dump($nextHike->getDate()->format('Y-m-d'));*/

        if($datecheck->format('Y-m-d') === $nextHike->getDate()->format('Y-m-d')){


            $users = $this->get('doctrine')
                ->getRepository('AppBundle:User')
                ->findSubscriberHike();
            foreach ($users as $user){
                /* @var User $user */

                $message = \Swift_Message::newInstance()
                    ->setSubject("Randonnée : ".$nextHike->getTitle())
                    ->setFrom('monique.boschatel@gmail.com', 'Les Déboussolés')
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        '@App/Emails/hikesRemimder.html.twig',
                        array(
                            'hike' => $nextHike,
                            'user' => $user,
                            'email' => $user->getEmail()
                        )
                    ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);
            }
        }

        /*$message = \Swift_Message::newInstance()
            ->setSubject('Hello , it\'s a test')
            ->setFrom('monique.boschatel@gmail.com')
            ->setTo('tilimac@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        var_dump($this->get('mailer')->send($message));*/

        //var_dump($hikeManager->getNextHikes());

        return new Response();
    }

    /**
     * @Route("/test", name="_emails_test")
     * @Template()
     */
    public function testAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello , it\'s a test')
            ->setFrom('monique.boschatel@gmail.com', 'Les Déboussolés')
            ->setTo('tilimac@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        var_dump($this->get('mailer')->send($message));

        return new Response();
    }

}
