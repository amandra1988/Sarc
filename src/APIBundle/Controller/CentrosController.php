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
        $groups  ='';
        $latitud = 0;
        $longitud= 0;
        $comuna  = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna')); 
        $centro = new CentroDeAcopio();
        $centro->setCenNombre($request->get('nombre'));
        $centro->setCenDireccion($request->get('direccion'));
        $centro->setCenNumero($request->get('numero'));
        $centro->setComuna($comuna);
        $centro->setCenVisible(true);
        if( null !== $request->get('latitud') ){
            $latitud = $request->get('latitud');
            $longitud= $request->get('longitud'); 
        }else{
            $direccion = $request->get('direccion').' '.$request->get('numero').', '.$comuna->getComNombre().', Chile';
            $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);        
            $latitud = $coordenadas['latitud'];
            $longitud= $coordenadas['longitud'];
        }
        $centro->setCenLatitud($latitud);
        $centro->setCenLongitud($longitud);
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
        $latitud = 0;
        $longitud= 0;
        
        if($request->get('comuna')){
            $comuna  = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna')); 
            $centro->setCenNombre($request->get('nombre'));
            $centro->setCenDireccion($request->get('direccion'));
            $centro->setCenNumero($request->get('numero'));
            $centro->setComuna($comuna);
            
            if( null !== $request->get('latitud') && $request->get('latitud') !='' ){
                $latitud = $request->get('latitud');
                $longitud= $request->get('longitud'); 
            }else{
                $direccion = $request->get('direccion').' '.$request->get('numero').', '.$comuna->getComNombre().', Chile';
                $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);        
                $latitud = $coordenadas['latitud'];
                $longitud= $coordenadas['longitud'];
            }
            $centro->setCenLatitud($latitud);
            $centro->setCenLongitud($longitud);
        }
        
        $centro->setCenVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($centro);
        $em->flush();
        return $this->serializedResponse($centro, $groups);
    }
}
