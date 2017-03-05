<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of MemberManager
 *
 * @author Valentin
 */
class MemberManager {
    
    protected $em;
    protected $repository;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Member');
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
}
