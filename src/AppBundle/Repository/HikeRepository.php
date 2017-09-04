<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of HikeRepository
 *
 * @author Tilimac
 */
class HikeRepository extends EntityRepository {
    public function findAllOrdered($sort,$direction) {
        $query = $this->createQueryBuilder('h')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query->getResult();
    }
    
    public function findNextHikes($limit = null) {
        $query = $this->createQueryBuilder('h')
            ->where("h.date > :now")
            ->setParameter('now', new \DateTime('now'))
            ->orderBy('h.date');
        if($limit !== null) $query->setMaxResults($limit);

        if($limit == 1){

            $queryHikeReported = $this->createQueryBuilder('h')
                ->where("h.dateReport > :now")
                ->setParameter('now', new \DateTime('now'))
                ->orderBy('h.dateReport')
                ->setMaxResults(1);

            $nextHikeReported = $queryHikeReported->getQuery()->getOneOrNullResult();
            $nextHike = $query->getQuery()->getOneOrNullResult();

            if($nextHikeReported !== null && $nextHikeReported->getDateReport() > new \DateTime() && $nextHikeReported->getDateReport() < $nextHike->getDate()){
                return $nextHikeReported;
            }
            else{
                return $nextHike;
            }
        }
        else{
            return $query->getQuery()->getResult();
        }
    }
    
    public function findPreviousHikes($limit = null) {
        $query = $this->createQueryBuilder('h')
            ->where("h.date < :now")
            ->setParameter('now', new \DateTime('now'))
            ->orderBy('h.date','DESC');
        if($limit !== null) $query->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }
}
