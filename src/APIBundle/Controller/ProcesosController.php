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
        $procesos = $this->getDoctrine()->getRepository('AppBundle:Proceso')->obtenerProcesosDeLaEmpresa($empresa->getId());
        return $this->serializedResponse($procesos, $groups);

    }

    public function patchEmpresasProcesosAction(Request $request,Empresa $empresa){
        $groups = ['proceso_detalle'];

        $proceso = $this->getDoctrine()->getRepository('AppBundle:Proceso')->find($request->get('idproceso'));

        $proceso->setPrcValidado($request->get('validar'));
        if($request->get('validar'))
            $proceso->setPrcObservacion('Proceso a la espera de ejecución');
        else
            $proceso->setPrcObservacion('');

        $em = $this->getDoctrine()->getManager();
        $em->persist($proceso);
        $em->flush();
        
        return $this->serializedResponse($proceso, $groups);
    }
}