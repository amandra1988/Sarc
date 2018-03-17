<?php

namespace AppBundle\Repository;

/**
 * ClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClienteRepository extends \Doctrine\ORM\EntityRepository
{
    public function obtenerClientesDeLaEmpresa($empresa, $region){

        $qb=$this->createQueryBuilder('c');
        $qb->add('from', 'AppBundle:Cliente c');
        $qb->innerJoin('c.usuario', 'u');
        $qb->innerJoin('u.empresa', 'e');
        $qb->innerJoin('c.comuna', 'com');
        $qb->innerJoin('com.provincia', 'pro');
        $qb->innerJoin('pro.region', 'reg');

        $qb->andWhere($qb->expr()->eq('c.cliVisible', 1));

        $qb->andWhere($qb->expr()->eq('u.empresa', ':empresa'))
            ->setParameter('empresa', $empresa);

        if($region)
            $qb->andWhere($qb->expr()->eq('pro.region', ':region'))
                ->setParameter('region', $region);

        return $qb->getQuery()->getResult();

    }
}
