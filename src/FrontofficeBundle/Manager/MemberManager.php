<?php
namespace FrontofficeBundle\Manager;

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
        $this->repository = $this->em->getRepository('FrontofficeBundle:Member');
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
}
