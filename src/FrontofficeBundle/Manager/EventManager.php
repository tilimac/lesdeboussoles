<?php
namespace FrontofficeBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of EventManager
 *
 * @author Valentin
 */
class EventManager {
    
    protected $em;
    protected $repository;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('FrontofficeBundle:Event');
    }

    public function getNextEvent()
    {
        return $this->repository->findNextEvent();
    }
}
