<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientesController extends APIBaseController
{
    /**
    * Obtener lista de operadores
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasClientesAction(Request $request, $idEmpresa){
        
        $groups = ['cliente_lista','comuna_detalle','frecuencia_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')->buscarSoloClientesVisibles($idEmpresa);
        return $this->serializedResponse($clientes, $groups); 
    }

}
