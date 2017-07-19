<?php

namespace APIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcesosController extends APIBaseController
{
    /**
    * Lista de procesos
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function getEmpresasProcesosAction(Request $request,$idEmpresa){
        $groups = ['proceso_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $procesos = $this->getDoctrine()->getRepository('AppBundle:Proceso')->buscarProcesosDeLaEmpresa($idEmpresa);
        return $this->serializedResponse($procesos, $groups);
    }
}