<?php
namespace AppBundle\Manager;

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
        $this->repository = $this->em->getRepository('AppBundle:Event');
    }

    public function getNextEvent()
    {
        return $this->repository->findNextEvent();
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }
}
