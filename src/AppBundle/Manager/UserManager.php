<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of UserManager
 *
 * @author Valentin
 */
class UserManager {
    
    protected $em;
    protected $repository;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:User');
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
}
