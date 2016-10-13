<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace FrontofficeBundle\Repository;

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
}
