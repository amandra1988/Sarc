<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OperadoresController extends APIBaseController
{
    /**
    * Obtener lista de operadores
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasOperadoresAction(Request $request, $idEmpresa){
        
        $groups = ['operador_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $operadores = $this->getDoctrine()->getRepository('AppBundle:Operador')->buscarSoloOperadoresVisibles($idEmpresa);
        return $this->serializedResponse($operadores, $groups); 
    }

}
