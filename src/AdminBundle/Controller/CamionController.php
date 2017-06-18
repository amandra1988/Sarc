<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class CamionController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/camiones/", name="camiones")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        
        return $this->render('AdminBundle:Camion:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'urlBase' => $this->getUrlBase('base', 'camion'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'camion'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api', 'camion')     
        ]);
    }
}
