<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ComentariosVisitasController extends APIBaseController
{
    /**
    * Obtener comentarios visitas del cliente
    * @return Response La respuesta serializada
    */ 
    public function getComentariosRutasAction(Request $request, Cliente $cliente, Ruta $ruta){
       

        $groups = ['r_ruta_detalle','rutaDet_detalle'];
        
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }

        $comentarios = $this->getDoctrine()->getRepository('AppBundle:RutaDetalle')->findBy(array('ruta'=>$ruta, 'cliente'=>$cliente));

        return $this->serializedResponse($comentarios, $groups);
    }
}