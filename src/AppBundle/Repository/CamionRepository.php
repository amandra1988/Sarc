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
   public function infoCamiones(){
        $qb=$this->createQueryBuilder('c')
                 ->add('from', 'AppBundle:Camion c')
                 ->add('where', 'c.camVisible =:visible')
                 ->setParameter('visible',1);
        return $qb->getQuery()->getResult();
    }
}
