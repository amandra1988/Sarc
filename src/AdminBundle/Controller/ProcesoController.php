<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class ProcesoController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/procesos/", name="procesos")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        
        return $this->render('AdminBundle:Proceso:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'urlBase' => $this->getUrlBase('base', 'proceso'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'proceso'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api', 'proceso')     
        ]);
    }
}
