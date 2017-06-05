<?php

namespace SuperadminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class CentroController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/centros/", name="centros")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        
        return $this->render('SuperadminBundle:Centro:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'urlBase' => $this->getUrlBase('base', 'centro'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'centro'),
            'urlBaseTemplates' => $this->getUrlBase('templates','superadmin'),
            'urlBaseApi' => $this->getUrlBase('api', 'centro')     
        ]);
    }
}
