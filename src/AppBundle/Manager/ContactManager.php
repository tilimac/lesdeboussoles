<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of ContactManager
 *
 * @author Valentin
 */
class ContactManager {
    
    protected $em;
    protected $repository;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Contact');
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
}
