<?php

namespace APIBundle\Controller;
use AppBundle\Entity\Empresa;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcesosController extends APIBaseController
{
    /**
    * Lista de procesos
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function getEmpresasProcesosAction(Request $request,Empresa $empresa){
        $groups = ['proceso_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $procesos = $this->getDoctrine()->getRepository('AppBundle:Proceso')->findBy(array('empresa'=>$empresa));
        return $this->serializedResponse($procesos, $groups);

    }
}