<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Repository;

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

    public function findNextBirthday($count = 1) {
        $dateNow = new \DateTime('now');

        $query = $this->createQueryBuilder('m')
            ->where('DAY(m.birthdate) > :dayBirthday')
            ->andWhere('MONTH(m.birthdate) > :monthBirthday')
            ->setParameter('dayBirthday', $dateNow->format('d'))
            ->setParameter('monthBirthday', $dateNow->format('m'))
            ->orderBy('m.birthdate', 'ASC')
            ->setMaxResults($count)
            ->getQuery();

        /*var_dump($query->getSQL());
        var_dump($query->getParameters());*/

        return $query->getResult();
    }
}
