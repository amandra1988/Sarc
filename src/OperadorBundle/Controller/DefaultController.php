<?php

namespace OperadorBundle\Controller;

use AppBundle\Traits\UrlBaseTraits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/", name="operador-dashboard")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        return $this->render('OperadorBundle:Default:index.html.twig',[
            'apikey'=>$usuario->getToken(),
            'urlBase'=>$this->getUrlBase('base'),
            'urlBaseImages' => $this->getUrlBase('img'),
            'urlBaseTemplates' => $this->getUrlBase('templates','operador'),
            'urlBaseApi' => $this->getUrlBase('api')
        ]);
    }
}
