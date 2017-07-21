<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of InvitationRepository
 *
 * @author Tilimac
 */
class InvitationRepository extends EntityRepository {
    public function findAllOrdered($sort,$direction) {
        $qb = $this->_em->createQueryBuilder();

        $nots = $qb->select('IDENTITY(u.invitation)')
            ->from('AppBundle:user', 'u')
            ->getQuery()
            ->getResult();

        $query = $qb->select('i')
            ->from('AppBundle:invitation', 'i')
            ->where($qb->expr()->notIn('i.code', array_reduce($nots, 'array_merge', array())))
            ->orderBy($sort, $direction)
            ->getQuery();


        /*$query = $this->createQueryBuilder('i')
            ->orderBy($sort, $direction)
            ->getQuery();*/

        return $query->getResult();
    }
}
