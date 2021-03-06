<?php

namespace AppBundle\Repository;

/**
 * CentroDeAcopioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CentroDeAcopioRepository extends \Doctrine\ORM\EntityRepository
{
    public function buscarSoloCentrosVisibles(){        
        $qb=$this->createQueryBuilder('c')
                 ->add('from', 'AppBundle:CentroDeAcopio c')
                 ->add('where', 'c.cenVisible =:visible')
                 ->setParameter('visible',1);
        return $qb->getQuery()->getResult();
    }
}
