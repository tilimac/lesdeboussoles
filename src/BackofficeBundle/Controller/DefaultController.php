<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Course;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $_SESSION['moxiemanager.filesystem.rootpath'] = realpath(__DIR__ . "/../../../web/uploads/randonnes"); // Set a root path for this use*/

        return array();
    }

    /**
     * @Route("/hikes/add", name="_admin_add_rike")
     * @Template()
     */
    public function addRikeAction(Request $request){
        $hike = new Hike();
        $hike->setImages(array(''));
        $hike->addCourse(new Course());
        $form = $this->createForm(new HikeType(), $hike);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
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
    public function editRikeAction(Request $request, Hike $hike){
        $hike = new Hike();
        $hike->setImages(array(''));
        $form = $this->createForm(new HikeType(), $hike);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
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
     * @Route("/hikes/list/", name="_admin_hikes_list")
     * @Template()
     */
    public function listHikesAction(){
        $query = $this->get('request')->query;
        $hikes = $this->get('doctrine')
            ->getRepository('FrontofficeBundle:Hike')
            ->findAllOrdered($query->get('sort','h.id'),$query->get('direction','asc'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hikes,
            $query->get('page',1),
            10
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/demandes/", name="_admin_requests")
     * @Template()
     */
    public function requestsAction(){
        $contactManager = $this->get('contact.manager');

        return array(
            'contacts' => $contactManager->getAll()
        );
    }
}
