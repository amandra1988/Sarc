<?php
namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Operador;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MisRutasController extends APIBaseController
{
    /**
    * Obtener mis rutas
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasOperadoresMisrutasAction(Request $request, Empresa $empresa, Operador $operador){
        
        $groups = ['ruta_lista'];
        
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }

        $misrutas = $this->getDoctrine()->getRepository('AppBundle:Ruta')->findBy(array('operador'=>$operador));
        
        return $this->serializedResponse($misrutas, $groups);
    }
}
