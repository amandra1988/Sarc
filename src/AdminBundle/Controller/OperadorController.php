<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class OperadorController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/operadores/", name="operadores")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();

        return $this->render('AdminBundle:Operador:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'urlBase' => $this->getUrlBase('base', 'operador'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'operador'),
            'urlBaseTemplates' => $this->getUrlBase('templates','admin'),
            'urlBaseApi' => $this->getUrlBase('api', 'operador')     
        ]);
    }
}
