<?php

namespace APIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrecuenciasController extends APIBaseController
{
    /**
    * Obtener lista de frecuencias
    * @return Response La respuesta serializada
    */ 
    public function getFrecuenciasAction(Request $request){
        
        $groups = ['frecuencia_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->findAll();
        return $this->serializedResponse($frecuencia, $groups); 
    }
}
