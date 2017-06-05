<?php

namespace APIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ComunasController extends APIBaseController
{
    /**
    * Obtener lista de comunas
    * @return Response La respuesta serializada
    */ 
    public function getComunasAction(Request $request){
        
        $groups = ['comuna_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $comunas = $this->getDoctrine()->getRepository('AppBundle:Comuna')->findAll();
        return $this->serializedResponse($comunas, $groups); 
    }
}
