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

    public function getNextBirthday($count = 1) {
        $statement = $this->em->getConnection()->prepare("SELECT * FROM  member WHERE  DATE_ADD(birthdate, INTERVAL YEAR(CURDATE())-YEAR(birthdate) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(birthdate),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 200 DAY)");
        //$statement->bindValue('id', 123);
        $statement->execute();

        return $statement->fetchAll();

        //return $this->repository->findNextBirthday($count);
    }
}
