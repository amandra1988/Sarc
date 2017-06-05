<?php

namespace APIBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RutasController extends APIBaseController
{
    /**
    * Obtener lista de rutas
    * @return Response La respuesta serializada
    */
    public function getEmpresasRutasAction(Request $request,$idEmpresa){
        $groups = ['ruta_lista','cliente_detalle','operador_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }    
        $camiones = $this->getDoctrine()->getRepository('AppBundle:Ruta')->buscarSoloRutasDeHoy($idEmpresa, '2017-06-05' /*date('Y-m-d')*/);
        return $this->serializedResponse($camiones, $groups); 
    }
}
