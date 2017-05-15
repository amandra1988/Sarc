<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
//use FOS\RestBundle\Controller\Annotations\QueryParam;
//use FOS\RestBundle\Request\ParamFetcher;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class EmpresasController extends APIBaseController
{
    /**
    * Obtener lista de empresas
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasAction(Request $request){
        
        $groups = ['empresa_lista'];
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
        $groups ='';
        $empresa = new Empresa();
        $empresa->setEmpNombre($request->get('nombre'));
        $empresa->setEmpRut($request->get('rut'));
        $empresa->setEmpDireccion($request->get('direccion'));
        $empresa->setEmpTelefono($request->get('telefono'));
        $empresa->setEmpCelular($request->get('celular'));
        $empresa->setEmpVisible(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($empresa);
        $em->flush();
        return $this->serializedResponse($empresa, $groups);
    }
    
    /**
    * Editar empresa
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function patchEmpresasAction(Request $request, Empresa $empresa){
        $groups ='';
        $empresa->setEmpNombre($request->get('nombre'));
        $empresa->setEmpRut($request->get('rut'));
        $empresa->setEmpDireccion($request->get('direccion'));
        $empresa->setEmpTelefono($request->get('telefono'));
        $empresa->setEmpCelular($request->get('celular'));
        $empresa->setEmpVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($empresa);
        $em->flush();
        return $this->serializedResponse($empresa, $groups);
    }
}
