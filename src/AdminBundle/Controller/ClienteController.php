<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class ClienteController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/clientes/", name="clientes")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        
        return $this->render('AdminBundle:Cliente:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'urlBase' => $this->getUrlBase('base', 'cliente'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'cliente'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api', 'cliente')     
        ]);
    }
}
