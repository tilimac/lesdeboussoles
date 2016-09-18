<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace FrontofficeBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of MemberRepository
 *
 * @author Tilimac
 */
class MemberRepository extends EntityRepository {
    public function findAllOrdered($sort,$direction) {
        $query = $this->createQueryBuilder('m')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query->getResult();
    }
}
