<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Form\Type\HikeType;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_admin_home")
     * @Template()
     */
    public function homeAction(){
        $_SESSION['isLoggedIn'] = true; // True/false if user is logged in or not, should be same as above
        $_SESSION['moxiemanager.filesystem.rootpath'] = realpath(__DIR__ . "/../../../web/uploads"); // Set a root path for this use*/

        return array();
    }

    /**
     * @Route("/randonnees/ajouter/", name="_admin_add_rike")
     * @Template()
     */
    public function addRikeAction(Request $request){
        $hike = new Hike();
        $hike->setImages(array(''));
        $form = $this->createForm(new HikeType(), $hike);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $gpx = $form['gpx']->getData();
            if($gpx !== null){
                $nameGpx = $gpx->getClientOriginalName();
                $gpx->move('uploads/gpx', $nameGpx);
                $hike->setGpx($nameGpx);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($hike);
            $em->flush();
        }
        /*
                ->add('image1', 'file')
                    ->add('image2', 'file', array('required' => false))
                    ->add('image3', 'file', array('required' => false))
                    ->add('save', 'submit')
                    ->getForm();

                $form->handleRequest($request);

                $isSaved = false;
                if($form->isValid()) {
                    $file1 = $form['image1']->getData();
                    $file2 = $form['image2']->getData();
                    $file3 = $form['image3']->getData();
                    $nameFile1 = $file1->getClientOriginalName();
                    $file1->move('uploads', $nameFile1);
                    $hike->setImage1($nameFile1);*/
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/randonnees/editer/{hike}/", name="_admin_edit_hike")
     * @Template()
     */
    public function editRikeAction(Request $request, Hike $hike){
        $listImage = array();
        foreach($hike->getImages() as $image){
            if($image != "") $listImage[] = $image;
        }
        $hike->setImages($listImage);
        $form = $this->createForm(new HikeType(), $hike);


        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $gpx = $form['gpx']->getData();
            $nameGpx = $gpx->getClientOriginalName();
            $gpx->move('uploads/gpx', $nameGpx);
            $hike->setGpx($nameGpx);

            $em = $this->getDoctrine()->getManager();
            $em->persist($hike);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/randonnees/list/", name="_admin_list_rikes")
     * @Template()
     */
    public function listRikesAction(){
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
