<?php
namespace APIBundle\Controller;

use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DetalleRutaController extends APIBaseController
{
    /**
    * Obtener detalle de una ruta
    * @return Response La respuesta serializada
    */ 
    public function getRutaAction(Request $request,$ruta){
        $groups = ['ruta_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $ruta = $this->getDoctrine()->getRepository('AppBundle:Ruta')->find($ruta);
        return $this->serializedResponse($ruta, $groups);
    }

    /**
    * Obtener detalle de una ruta
    * @return Response La respuesta serializada
    */ 
    public function postRutaAction(Request $request, RutaDetalle $rutadetalle){
        $groups = '';
        $rutadetalle->setRdeComentario($request->get('comentario'));
        $rutadetalle->setRdeEstado($request->get('estado'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($rutadetalle);
        $em->flush();
        return $this->serializedResponse($rutadetalle->getId(), $groups);
    }
}