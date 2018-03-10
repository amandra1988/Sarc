<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class RutaController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/rutas/", name="rutas")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        
        return $this->render('AdminBundle:Ruta:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'urlBase' => $this->getUrlBase('base', 'ruta'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'ruta'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api', 'ruta')     
        ]);
    }
}
