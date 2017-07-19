<?php

namespace ClienteBundle\Controller;

use AppBundle\Traits\UrlBaseTraits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/", name="cliente-dashboard")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        return $this->render('ClienteBundle:Default:index.html.twig',[
            'apikey'=>$usuario->getToken(),
            'urlBase'=>$this->getUrlBase('base'),
            'urlBaseImages' => $this->getUrlBase('img'),
            'urlBaseTemplates' => $this->getUrlBase('templates','cliente'),
            'urlBaseApi' => $this->getUrlBase('api')
        ]);
    }
}
