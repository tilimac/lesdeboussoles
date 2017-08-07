<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Description of ContactManager
 *
 * @author Valentin
 */
class InvitationManager {
    
    protected $em;
    protected $repository;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Invitation');
    }

    public function getInvitationByEmail($email) {
        return $this->repository->findOneByEmail($email);
    }
}
