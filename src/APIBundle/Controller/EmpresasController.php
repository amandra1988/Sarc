<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\ConfiguracionAmpl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresasController extends APIBaseController
{
    /**
    * Obtener lista de empresas
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasAction(Request $request){
        
        $groups = ['empresa_lista','centro_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $empresas = $this->getDoctrine()->getRepository('AppBundle:Empresa')->buscarSoloEmpresasVisibles();
        return $this->serializedResponse($empresas, $groups); 
    }
    
    /**
    * Nueva empresa
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function postEmpresasAction(Request $request){
        $groups =['empresa_detalle'];
        $centroDeAcopio  = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->find($request->get('centro'));
        
        $em = $this->getDoctrine()->getManager();

        $empresa = new Empresa();
        $empresa->setCentroDeAcopio($centroDeAcopio)
                ->setEmpNombre($request->get('nombre'))
                ->setEmpRut($request->get('rut'))
                ->setEmpDireccion($request->get('direccion'))
                ->setEmpVisible(true)
                ->setEmpCelular($request->get('celular'))
                ->setEmpTelefono($request->get('telefono')); 
        
        $em->persist($empresa);
        $em->flush();

        $configuracion = new ConfiguracionAmpl();
        $configuracion
            ->setEmpresa($empresa)
            ->setDias(21)
            ->setInfinito(360)
            ->setEpsilon(20)
            ->setEpciloDos(7);

        $em->persist($configuracion);
        $em->flush();

        return $this->serializedResponse($empresa, $groups);
    }
    
    /**
    * Editar empresa
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function patchEmpresasAction(Request $request, Empresa $empresa){
        $groups =['empresa_detalle'];
        if($request->get('centro')){
            $centroDeAcopio  = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->find($request->get('centro')); 
            $empresa->setCentroDeAcopio($centroDeAcopio);  
            $empresa->setEmpNombre($request->get('nombre'));
            $empresa->setEmpRut($request->get('rut'));
            $empresa->setEmpDireccion($request->get('direccion'));
            $empresa->setEmpTelefono($request->get('telefono'));
            $empresa->setEmpCelular($request->get('celular'));
        }
        $empresa->setEmpVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($empresa);
        $em->flush();
        return $this->serializedResponse($empresa, $groups);
    }
}
