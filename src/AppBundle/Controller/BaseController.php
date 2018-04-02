<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Traits\BaseTraits;

class BaseController extends Controller
{
    use BaseTraits;

    protected $class = null;
    protected $bundle = 'AppBundle';

    protected function repo($class = null, $bundle = null){
        if(!is_string($class)){
            $class = $this->class;
        }
        if(!is_string($bundle)){
            $bundle = $this->bundle;
        }
        return $this->getDoctrine()->getRepository("$bundle:$class");
    }
}