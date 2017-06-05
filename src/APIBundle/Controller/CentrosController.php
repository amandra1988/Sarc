<?php

namespace APIBundle\Controller;

use AppBundle\Entity\CentroDeAcopio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CentrosController extends APIBaseController
{
    /**
    * Obtener lista de centros de acopio
    * @return Response La respuesta serializada
    */ 
    public function getCentrosAction(Request $request){
        
        $groups = ['centro_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $centros = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->buscarSoloCentrosVisibles();
        return $this->serializedResponse($centros, $groups); 
    }
    
    /**
    * Nuevo centro de acopio
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function postCentrosAction(Request $request){
        $groups ='';
        $comuna  = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna')); 
        $centro = new CentroDeAcopio();
        $centro->setCenNombre($request->get('nombre'));
        $centro->setCenDireccion($request->get('direccion'));
        $centro->setCenNumero($request->get('numero'));
        $centro->setComuna($comuna);
        $centro->setCenVisible(true);
        //$direccion = 
        //$comuna  = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion); 
        $centro->setCenLongitud(0);
        $centro->setCenLatitud(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($centro);
        $em->flush();
        return $this->serializedResponse($centro, $groups);
    }
    
    /**
    * Editar centro de acopio
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function patchCentrosAction(Request $request, CentroDeAcopio $centro){
        $groups ='';
        $comuna  = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna')); 
        $centro->setCenNombre($request->get('nombre'));
        $centro->setCenDireccion($request->get('direccion'));
        $centro->setCenNumero($request->get('numero'));
        $centro->setComuna($comuna);
        $centro->setCenVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($centro);
        $em->flush();
        return $this->serializedResponse($centro, $groups);
    }
}
