<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitasController extends APIBaseController
{
    /**
    * Obtener visitas del cliente
    * @return Response La respuesta serializada
    */ 
    public function getVisitasclienteAction(Request $request,Cliente $cliente){
        
        $groups = ['ruta_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $misrutas = $this->getDoctrine()->getRepository('AppBundle:Ruta')->buscarVisitas($cliente);
        return $this->serializedResponse($misrutas, $groups);
    }
}