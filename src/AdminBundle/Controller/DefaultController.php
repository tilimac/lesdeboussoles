<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\HikeType;
use AdminBundle\Form\Type\NewsletterType;
use AppBundle\Entity\Course;
use AppBundle\Entity\Hike;
use AppBundle\Entity\Image;
use AppBundle\Entity\Member;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_admin_home")
     */
    public function homeAction(Request $request){
        $_SESSION['isLoggedIn'] = true; // True/false if user is logged in or not, should be same as above
        $_SESSION['moxiemanager.filesystem.rootpath'] = realpath(__DIR__ . "/../../../web/uploads/randonnes");
        $_SESSION['moxiemanager.filesystem.local.wwwroot'] = realpath(__DIR__ . "/../../../web/uploads/randonnes");

        $hikeManager = $this->get('hike.manager');
        $eventManager = $this->get('event.manager');
        $contactManager = $this->get('contact.manager');
        $userManager = $this->get('fos_user.user_manager');
        $memberManager = $this->get('member.manager');

        $nextEvents = $eventManager->getNextEvent();

        $nextHikes = $hikeManager->getNextHikes();

        $contacts = $contactManager->getAll();

        $users = $userManager->findUsers();


        $newsletter = new Newsletter();
        $form = $this->createForm(new NewsletterType(), $newsletter);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $newsletter->setDate(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Mail envoyé avec succés')
            ;

            $users = $this->get('doctrine')
                ->getRepository('AppBundle:User')
                ->findSubscriberNewsletter();

            foreach ($users as $user){
                /* @var User $user */

                $message = \Swift_Message::newInstance()
                    ->setSubject($newsletter->getTitle())
                    ->setFrom('monique.boschatel@gmail.com', 'Les Déboussolés')
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        '@App/Emails/newsletter.html.twig',
                        array(
                            'newsletter' => $newsletter,
                            'user' => $user
                        )
                    ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);
            }
        }


        return $this->render('@Admin/Default/home.html.twig', array(
            'nextEvents' => $nextEvents,
            'nextHikes' => $nextHikes,
            'contacts' => $contacts,
            'users' => $users,
            'form' => $form->createView(),
            'nextBirthday' => $memberManager->getNextBirthday(5)
        ));
    }
}
