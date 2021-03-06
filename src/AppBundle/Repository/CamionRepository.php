<?php

namespace AppBundle\Repository;

/**
 * CamionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CamionRepository extends \Doctrine\ORM\EntityRepository
{
    public function buscarCamionesDeLaEmpresa($empresa,$operativo=null){

        $qb=$this->createQueryBuilder('c');
        $qb->add('from', 'AppBundle:Camion c');
        $qb->innerJoin('c.operador', 'o');
        $qb->innerJoin('o.usuario', 'u');

        $qb->andWhere($qb->expr()->eq('c.camVisible', 1));
        $qb->andWhere($qb->expr()->eq('u.empresa', ':empresa'))
            ->setParameter('empresa', $empresa);

        if($operativo)
            $qb->andWhere($qb->expr()->eq('c.camEstado', ':estado'))
                ->setParameter('estado', 1);

        return $qb->getQuery()->getResult();

    }
}
