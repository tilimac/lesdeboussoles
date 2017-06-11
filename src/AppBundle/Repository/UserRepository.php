<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author Tilimac
 */
class UserRepository extends EntityRepository {
    public function findAllOrdered($sort,$direction) {
        $query = $this->createQueryBuilder('u')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query->getResult();
    }

    public function findSubscriberNewsletter() {
        $query = $this->createQueryBuilder('u')
            ->where('u.emailNewsletter = 1')
            ->getQuery();

        return $query->getResult();
    }

    public function findSubscriberHike() {
        $query = $this->createQueryBuilder('u')
            ->where('u.emailHike = 1')
            ->getQuery();

        return $query->getResult();
    }
}
