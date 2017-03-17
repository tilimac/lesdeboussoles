<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\HikeType;
use AdminBundle\Form\Type\MessageType;
use AppBundle\Entity\Course;
use AppBundle\Entity\Hike;
use AppBundle\Entity\Image;
use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_admin_home")
     * @Template()
     */
    public function homeAction(){
        $_SESSION['isLoggedIn'] = true; // True/false if user is logged in or not, should be same as above
        $_SESSION['moxiemanager.filesystem.rootpath'] = realpath(__DIR__ . "/../../../web/uploads/randonnes");
        $_SESSION['moxiemanager.filesystem.local.wwwroot'] = realpath(__DIR__ . "/../../../web/uploads/randonnes");

        $hikeManager = $this->get('hike.manager');
        $eventManager = $this->get('event.manager');
        $contactManager = $this->get('contact.manager');
        $memberManager = $this->get('fos_user.user_manager');

        $nextEvents = $eventManager->getNextEvent();

        $nextHikes = $hikeManager->getNextHikes();

        $contacts = $contactManager->getAll();

        $users = $memberManager->findUsers();



        $form = $this->createForm(new MessageType(), new Message());

        return array(
            'nextEvents' => $nextEvents,
            'nextHikes' => $nextHikes,
            'contacts' => $contacts,
            'users' => $users,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/hikes/add", name="_admin_add_rike")
     * @Template()
     */
    public function addHikeAction(Request $request){


        $hike = new Hike();
        $hike->addImage(new Image());
        $hike->addCourse(new Course());
        $form = $this->createForm(new HikeType(), $hike);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'La randonnée a été ajouter avec succés')
            ;
            foreach($hike->getCourses() as $key => $course) {
                $course->setHike($hike);
                $gpx = $course->getGpx();
                if($gpx !== null){
                    /* @var UploadedFile $gpx */
                    $nameGpx = "hike_".time().$key.".gpx";
                    $gpx->move('uploads/gpx', $nameGpx);
                    $course->setGpx($nameGpx);
                }
            }

            /*$images = array();
            foreach ($form['images']->getData() as $image) {
                $image->move('uploads/hikes', $image->getClientOriginalName());
                $images[] = $image->getClientOriginalName();
            }
            $hike->setImages($images);*/
            /*$images = array();
            foreach ($hike->getImages() as $image) {
                $images[] = '/web/uploads/randonnes'.$image;
            }
            $hike->setImages($images);*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($hike);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/hikes/{hike}/edit", name="_admin_edit_hike")
     * @Template()
     */
    public function editHikeAction(Request $request, Hike $hike){

        /*$message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('monique.boschatel@gmail.com')
            ->setTo('tilimac@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        var_dump($this->get('mailer')->send($message));*/


        //$hike->setImages(array(''));
        $form = $this->createForm(new HikeType(), $hike);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()) {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'La randonnée a été modifier avec succés')
            ;
            foreach($hike->getCourses() as $key => $course) {
                $course->setHike($hike);
                $gpx = $course->getGpx();
                if($gpx !== null){
                    /* @var UploadedFile $gpx */
                    $nameGpx = "hike_".time().$key.".gpx";
                    $gpx->move('uploads/gpx', $nameGpx);
                    $course->setGpx($nameGpx);
                }
            }
/*
            $images = array();
            foreach ($hike->getImages() as $image) {
                //var_dump($image);
                //$images[] = '/web/uploads/randonnes'.$image;
            }
            $hike->setImages($images);*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($hike);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/hikes/{hike}/delete", name="_admin_hikes_delete")
     */
    public function deleteHikesAction(Hike $hike)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($hike);
        $em->flush();

        return $this->redirectToRoute('_admin_hikes_list');
    }

    /**
     * @Route("/courses/{course}/delete", name="_admin_courses_delete", options={"expose"=true})
     */
    public function deleteCoursesAction(Course $course)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/hikes/list/", name="_admin_hikes_list")
     * @Template()
     */
    public function listHikesAction(){
        $query = $this->get('request')->query;
        $hikes = $this->get('doctrine')
            ->getRepository('AppBundle:Hike')
            ->findAllOrdered($query->get('sort','h.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hikes,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }
}
