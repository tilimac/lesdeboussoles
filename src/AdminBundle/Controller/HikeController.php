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

class HikeController extends Controller
{
    /**
     * @Route("/hikes/list/", name="_admin_hikes_list")
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

        return $this->render('@Admin/Default/listHikes.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * @Route("/hikes/add", name="_admin_add_rike")
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

        return $this->render('@Admin/Default/addHike.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/hikes/{hike}/edit", name="_admin_edit_hike")
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

        return $this->render('@Admin/Default/editHike.html.twig', array(
            'form' => $form->createView(),
        ));
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
     * @Route("/hikes/{hike}/status", name="_admin_hikes_status", options={"expose"=true})
     */
    public function statusHikesAction(Request $request, Hike $hike)
    {
        $em = $this->getDoctrine()->getManager();

        $hike->setCanceled($request->get('status'));
        //$hike->setDateReport($hike->getDate());
        //$hike->setDate(\DateTime::createFromFormat("d/m/Y H:i",$request->get('date')));

        $em->persist($hike);
        $em->flush();

        switch ($request->get('status')){
            case 1://Annulé
                //echo "i égal 0";
                break;
            case 2://Repporté
                $message = \Swift_Message::newInstance()
                    ->setSubject('Report de la randonnée')
                    ->setFrom('monique.boschatel@gmail.com', 'Les déboussolés')
                    ->setTo('tilimac@gmail.com')
                    ->setBody($this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                                '@App/Emails/postponed.html.twig',
                                array(
                                    'hike' => $hike,
                                    'today' => new \DateTime('now')
                                )
                            ),
                            'text/html'
                    );
                $this->get('mailer')->send($message);
                break;
            default:
        }

        return new Response();
    }
}
