<?php

namespace ClienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class VisitasController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/visitas/", name="visitas")
     */
    public function indexAction()
    {
        $usuario   = $this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        $idCliente = $this->getUser()->getCliente()->getId();

        return $this->render('ClienteBundle:Visitas:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'idCliente'=>$idCliente,
            'urlBase' => $this->getUrlBase('base', 'visitas'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'visitas'),
            'urlBaseTemplates' => $this->getUrlBase('templates','cliente'),
            'urlBaseApi' => $this->getUrlBase('api', 'visitas')     
        ]);
    }
}
