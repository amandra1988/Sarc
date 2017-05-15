<?php

namespace SuperadminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class EmpresaController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/empresas/", name="empresas")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        
        return $this->render('SuperadminBundle:Empresa:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'urlBase' => $this->getUrlBase('base', 'empresa'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'empresa'),
            'urlBaseTemplates' => $this->getUrlBase('templates','superadmin'),
            'urlBaseApi' => $this->getUrlBase('api', 'empresa')     
        ]);
    }
}
