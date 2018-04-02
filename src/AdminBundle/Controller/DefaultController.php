<?php

namespace AdminBundle\Controller;

use AppBundle\Traits\UrlBaseTraits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/", name="admin-dashboard")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        return $this->render('AdminBundle:Default:index.html.twig',[
            'apikey'=>$usuario->getToken(),
            'urlBase'=>$this->getUrlBase('base'),
            'urlBaseImages' => $this->getUrlBase('img'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api')
        ]);
    }
}
