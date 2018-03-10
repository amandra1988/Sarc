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
        $groups = ['ruta_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $anio = $request->get('anio');
        $mes  = date('m',$request->get('mes'));

        $rutas = $this->getDoctrine()->getRepository('AppBundle:Ruta')->buscarRutasDelMes($mes,$anio,$idEmpresa); 
        return $this->serializedResponse($rutas, $groups);
    }
}
