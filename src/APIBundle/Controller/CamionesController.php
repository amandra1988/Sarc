<?php

namespace APIBundle\Controller;
use AppBundle\Entity\Camion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CamionesController extends APIBaseController
{
    /**
    * Obtener lista de camiones de una empresa
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasCamionesAction(Request $request,$idEmpresa){
        $groups = ['camion_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }    
        $camiones = $this->getDoctrine()->getRepository('AppBundle:Camion')->buscarSoloCamionesVisibles($idEmpresa);
        return $this->serializedResponse($camiones, $groups); 
    }
    
    /**
    * Obtener lista de camiones de una empresa
    * @return Response La respuesta serializada
    */ 
    public function postEmpresasCamionesAction(Request $request,$idEmpresa){
        
        $empresa =  $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($idEmpresa);
        $groups ='';
        $camion = new Camion();
        $camion->setCamPatente($request->get('patente'));
        $camion->setCamCapacidad($request->get('capacidad'));
        $camion->setCamEstado(1);
        $camion->setCamTipoCarga($request->get('tipo_carga'));
        $camion->setCamVisible(true);
        $camion->setEmpresa($empresa);
        $em = $this->getDoctrine()->getManager();
        $em->persist($camion);
        $em->flush();
        return $this->serializedResponse($camion, $groups);
    }
    
    public function patchEmpresasCamionesAction(Request $request,$idEmpresa, Camion $camion){
        $groups ='';
        $camion->setCamPatente($request->get('patente'));
        $camion->setCamCapacidad($request->get('capacidad'));
        $camion->setCamEstado($request->get('estado'));
        $camion->setCamTipoCarga($request->get('tipo_carga'));
        $camion->setCamVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($camion);
        $em->flush();
        return $this->serializedResponse($camion, $groups);
    }
}
