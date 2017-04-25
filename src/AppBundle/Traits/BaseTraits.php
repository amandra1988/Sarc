<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:49
 */
namespace AppBundle\Traits;

trait BaseTraits{

    /**
     * @return \Doctrine\ORM\Repository
     */
    protected function repo()
    {
        throw new \Exception('Method needs implementation');
    }

    /**
     * @return \AppBundle\Repository\UserRepository
     */
    protected function getRepoUser(){
        return $this->repo('User');
    }

}