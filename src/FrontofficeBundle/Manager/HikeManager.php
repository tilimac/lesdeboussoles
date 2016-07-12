<?php
namespace FrontofficeBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of HikeManager
 *
 * @author Valentin
 */
class HikeManager {
    
    protected $em;
    protected $repository;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('FrontofficeBundle:Hike');
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
    
    public function getHike($id) {
        return $this->repository->find($id);
    }
    
    public function getNextHikes($limit = null) {
        return $this->repository->findNextHikes($limit);
    }
    
    public function getPreviousHikes($limit = null) {
        return $this->repository->findPreviousHikes($limit);
    }
}
