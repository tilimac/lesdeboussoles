<?php

namespace FrontofficeBundle\Controller;

use FrontofficeBundle\Entity\Contact;
use FrontofficeBundle\Entity\Event;
use FrontofficeBundle\Entity\Hike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function homeAction(){
        $hikeManager = $this->get('hike.manager');
        $eventManager = $this->get('event.manager');

        $nextEvents = $eventManager->getNextEvent();
        //$nextEvent = empty($nextEvents) ? NULL : $nextEvents[0];

        $nextHikes = $hikeManager->getNextHikes(1);
        $nextHike = empty($nextHikes) ? NULL : $nextHikes[0];

        return array(
            'nextEvents' => $nextEvents,
            'nextHike' => $nextHike,
            'previousHikes' => $hikeManager->getPreviousHikes(6)
        );
    }

    /**
     * @Route("/randonnees/precedentes/", name="_previous_hikes")
     * @Template()
     */
    public function previousHikesAction(){
        $hikeManager = $this->get('hike.manager');

        return array(
            'previousHikes' => $hikeManager->getPreviousHikes()
        );
    }

    /**
     * @Route("/randonnees/prochaines/", name="_next_hikes")
     * @Template()
     */
    public function nextHikesAction(){
        $hikeManager = $this->get('hike.manager');

        return array(
            'nextHikes' => $hikeManager->getNextHikes()
        );
    }

    /**
     * @Route("/randonnee/{hike}/", name="_hike")
     * @Template()
     */
    public function hikeAction(Hike $hike){
        $path = __DIR__ . "/../../../web/uploads/hike/".$hike->getId()."/";
        $pathTumb = $path."mcith/";

        if(!is_dir($path)) mkdir($path);

        $_SESSION['isLoggedIn'] = true; // True/false if user is logged in or not, should be same as above
        $_SESSION['moxiemanager.filesystem.rootpath'] = $hike->getTitle()."=".realpath($path); // Set a root path for this use*/
        $_SESSION['moxiemanager.filesystem.local.wwwroot'] = realpath($path);

        $picturesList = array_diff(scandir($path), array('..', '.', 'mcith'));

        /*foreach ($hike->getCourses() as $course) {
            $xml=new \SimpleXMLElement(file_get_contents('/uploads/gpx/'.$course->getGpx()));

            $carte = array();
            $minLon = null;
            $maxLon = null;
            $minLat = null;
            $maxLat = null;
            foreach($xml->trk->trkseg->trkpt as $value) {
                $lon = floatval($value['lon']);
                $lat = floatval($value['lat']);
                $ele = intval($value->ele);

                if(count($carte) == 0){
                    $minLon = $maxLon = $lon;
                    $minLat = $maxLat = $lat;
                }

                if($minLon > $lon) $minLon = $lon;
                if($maxLon < $lon) $maxLon = $lon;
                if($minLat > $lon) $minLat = $lat;
                if($maxLat < $lon) $maxLat = $lat;

                $coord = array($lon,$lat,$ele);
                $carte[] = $coord;
            }
        }*/

        $dificulty = array(
            "Facile",
            "Moyen",
            "Difficile"
        );

        return array(
            'hike' => $hike,
            'dificulty' => $dificulty,
            'picturesList' => $picturesList
        );
    }

    /**
     * @Route("/association/", name="_association")
     * @Template()
     */
    public function associationAction(){
        return array();
    }

    /**
     * @Route("/loi/", name="_loi")
     * @Template()
     */
    public function loiAction(){
        return array();
    }

    /**
     * @Route("/contact/", name="_contact")
     * @Template()
     */
    public function contactAction(){
        $contact = new Contact();
        $request = $this->get('request');

        $formBuilder = $this->get('form.factory')->createBuilder('form', $contact);

        $formBuilder
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('phoneNumber', 'text')
            ->add('mail', 'text')
            ->add('message', 'textarea')
            ->add('save', 'submit', array('label' => 'Envoyer'));
        $form = $formBuilder->getForm();

        $formEmpty = $form;

        $form->handleRequest($request);

        $success = NULL;
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $contact->setDate(new \DateTime());
            $em->persist($contact);
            $em->flush();

            $success = true;
        }

        return array(
            'form' => $form->createView(),
            'success' => $success
        );
    }

    /**
     * @Route("/calendrier/", name="_calendar")
     * @Template()
     */
    public function calendarAction(){
        $hikeManager = $this->get('hike.manager');
        $eventManager = $this->get('event.manager');
        $months = array(NULL, 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        $numDay = array(NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);


        $now = new \DateTime();
        $now->modify('first day of this month');
        $nbDayByMonth = array();
        $firstDayByMonth = array();
        $count = 0;
        $currentYear = intval($now->format('Y'));
        $nextYear = $currentYear + 1;
        for ($i = 0; $i < 12; $i++) {
            $month = $now->format('n');
            $year = $now->format('Y');
            $date = $now->modify('first sunday');
            $nbDayByMonth[$month] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $numDay = $date->format('j');
            $firstDayByMonth[$month] = intval(($numDay >= 8) ? $numDay-7 : $numDay);
            $isWeekEnd[$month] = array_fill(0, 35, false);
            for($j=0;$j<5;$j++){
                $isWeekEnd[$month][$firstDayByMonth[$month]+7*$j] = true;
            }
            $now->modify('first day of this month');
            $now->add(new \DateInterval('P1M'));
            //var_dump(new \DateInterval('P1M'));
            if ($month == 1)
                $nbMonthCurrentYear = $count;
            $count++;
        }


        /*var_dump($nbDayByMonth);
        var_dump($firstDayByMonth);*/

//var_dump($nbDayByMonth);

        if ($nbMonthCurrentYear == 0)
            $nbMonthCurrentYear = 12;
        $nbMonthnextYear = 12 - $nbMonthCurrentYear;


        $programmeHike = array();
        foreach ($hikeManager->getAll() as $hike) {
            /* @var Hike $hike */
            if($hike->getDate() >= new \DateTime()){
                $month = $hike->getDate()->format('n');
                $day = $hike->getDate()->format('j');
                $programmeHike[$month][$day] = $hike;
            }
        }

        $programmeEvent = array();
        foreach ($eventManager->getAll() as $event) {
            /* @var Event $event */
            if($event->getDateEvent() >= new \DateTime()){
                $month = $event->getDateEvent()->format('n');
                $day = $event->getDateEvent()->format('j');
                $programmeEvent[$month][$day] = $event;
            }
        }

        return array(
            'months' => $months,
            'firstDayByMonth' => $firstDayByMonth,
            'programmeHike' => $programmeHike,
            'programmeEvent' => $programmeEvent,
            'nbMonthCurrentYear' => $nbMonthCurrentYear,
            'currentYear' => $currentYear,
            'nextYear' => $nextYear,
            'nbMonthnextYear' => $nbMonthnextYear,
            'nbDayByMonth' => $nbDayByMonth,
            'isWeekEnd' => $isWeekEnd
        );
    }

    /**
     * @Route("/calendrieralign/", name="_calendar_old")
     * @Template()
     */
    public function calendarOldAction(){
        $hikeManager = $this->get('hike.manager');
        $months = array(NULL, 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        $numDay = array(NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);


        $now = new \DateTime();
        $nbDayByMonth = array();
        $firstDayByMonth = array();
        $count = 0;
        $currentYear = intval($now->format('Y'));
        $nextYear = $currentYear+1;
        for ($i = 0; $i < 12; $i++) {
            $month = $now->format('n');
            $year = $now->format('Y');
            $nbDayByMonth[$month] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $firstDayByMonth[$month] = date("w", mktime(0, 0, 0, $month, 1, date("Y") ));
            $now->add(new \DateInterval('P1M'));
            if($month == 1) $nbMonthCurrentYear = $count;
            $count++;
        }

        if($nbMonthCurrentYear == 0) $nbMonthCurrentYear=12;
        $nbMonthnextYear = 12-$nbMonthCurrentYear;

        $calendar = array();
        for ($i = 1; $i <= 37; $i++) {
            $day = $i%7;
            $calendarLine = array();
            foreach ($nbDayByMonth as $month => $number) {
                if(($firstDayByMonth[$month] == $day || $numDay[$month] > 1) && $nbDayByMonth[$month] >= $numDay[$month]){
                    $calendarLine[$month] = $numDay[$month];
                    $numDay[$month]++;
                }
                else{
                    $calendarLine[$month] = NULL;
                }
            }
            $calendar[] = $calendarLine;
        }

        $programme = array();
        foreach ($hikeManager->getAll() as $hike) {
            $month = $hike->getDate()->format('n');
            $day = $hike->getDate()->format('j');
            $programme[$month][$day] = $hike;
        }

        return array(
            'months' => $months,
            'days' => $days,
            'calendar' => $calendar,
            'nbDayByMonth' => $nbDayByMonth,
            'programme' => $programme,
            'currentYear' => $currentYear,
            'nextYear' => $nextYear,
            'nbMonthCurrentYear' => $nbMonthCurrentYear,
            'nbMonthnextYear' => $nbMonthnextYear
        );
    }

    /**
     * @Route("/hike/{hike}/pictures/", name="_hike_pictures")
     * @Template()
     */
    public function picturesAction(Hike $hike){
        $path = __DIR__ . "/../../../web/uploads/hike/".$hike->getId()."/";
        $pathTumb = $path."mcith/";

        if(!is_dir($path)) mkdir($path);


        $picturesList = array_diff(scandir($path), array('..', '.', 'mcith'));

        return array(
            'hike' => $hike,
            'picturesList' => $picturesList
        );
    }
}
