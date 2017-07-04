<?php

namespace OperadorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class MisRutasController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/misrutas/", name="mis-rutas")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        $idEmpresa = $this->getUser()->getEmpresa()->getId();
        $idOperador= $this->getUser()->getOperadores()->getId();
        
        return $this->render('OperadorBundle:MisRutas:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'idEmpresa'=>$idEmpresa,
            'idOperador'=>$idOperador,
            'urlBase' => $this->getUrlBase('base', 'misrutas'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'misrutas'),
            'urlBaseTemplates' => $this->getUrlBase('templates','operador'),
            'urlBaseApi' => $this->getUrlBase('api', 'misrutas')     
        ]);
    }
}
