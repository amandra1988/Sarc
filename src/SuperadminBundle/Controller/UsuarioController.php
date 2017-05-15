<?php

namespace SuperadminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Traits\UrlBaseTraits;

class UsuarioController extends Controller
{
    use UrlBaseTraits;
    /**
     * @Route("/usuarios/", name="usuarios")
     */
    public function indexAction()
    {
        $usuario=$this->getUser();
        return $this->render('SuperadminBundle:Usuario:index.html.twig', [
            'apikey'=>$usuario->getToken(),
            'urlBase' => $this->getUrlBase('base', 'usuario'),
            'urlBaseImagenes' => $this->getUrlBase('img', 'usuario'),
            'urlBaseTemplates' => $this->getUrlBase('templates','superadmin'),
            'urlBaseApi' => $this->getUrlBase('api', 'usuario')     
        ]);
   
    }
    
}
