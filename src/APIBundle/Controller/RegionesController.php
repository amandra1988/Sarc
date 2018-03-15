<?php

namespace APIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegionesController extends APIBaseController
{
    /**
     * Lista de regiones
     * @param Request $request La petición
     * @return Response La respuesta serializada
     */
    public function getRegionesAction(Request $request){
        $groups = ['region_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $regiones = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();

        return $this->serializedResponse($regiones, $groups);
    }
}
