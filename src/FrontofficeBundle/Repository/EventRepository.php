<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace FrontofficeBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of EventRepository
 *
 * @author Tilimac
 */
class EventRepository extends EntityRepository {
    public function findNextEvent()
    {
        $query = $this->createQueryBuilder('h')
            ->where("h.dateCreate < :now")
            ->andWhere("h.dateEvent > :now")
            ->setParameter('now', new \DateTime('now'))
            ->orderBy('h.dateEvent')
            ->setMaxResults(1);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findAllOrdered($sort,$direction) {
        $query = $this->createQueryBuilder('h')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query->getResult();
    }
}
