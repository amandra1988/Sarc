<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\User;
use AppBundle\Entity\Operador;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OperadoresController extends APIBaseController
{
    /**
    * Obtener lista de operadores
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasOperadoresAction(Request $request, $idEmpresa){
        
        $groups = ['operador_lista'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $operadores = $this->getDoctrine()->getRepository('AppBundle:Operador')->buscarSoloOperadoresVisibles($idEmpresa);
        return $this->serializedResponse($operadores, $groups); 
    }
    
    public function postEmpresasOperadoresAction(Request $request, Empresa $empresa){
        $groups =['operador_detalle'];
        $em = $this->getDoctrine()->getManager();
        
        $rut = str_replace('.','', str_replace('-', '', $request->get('rut')));
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Operador')->existeElUsuario($rut);
    
        if( count($usuario) === 0){
            $usuario = new User();
        }else{
            if($usuario[0]->getVisible() == 0){
                $usuario = $usuario[0]; 
            }else{
                $respuesta['error'] ="Ya existe un operador con el rut ingresado!";
                return $this->serializedResponse($respuesta,''); 
            }
        }

        $rol   = $this->getDoctrine()->getRepository('AppBundle:Rol')->find(4); 
        $token = $this->getDoctrine()->getRepository('AppBundle:User')->obtenerTokenParaElUsuario();
        $pass  = $this->container->get('security.password_encoder');
        $password = $pass->encodePassword($usuario,12345);
        $usuario->setEmpresa($empresa)->setRol($rol)->setUsername($rut)->setPassword($password)->setToken($token);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        $operador= new Operador();
        $operador->setOpeNombre($request->get('nombre'))
                 ->setOpeApellido($request->get('apellido'))
                 ->setOpeLicencia($request->get('licencia'))
                 ->setOpeRut($rut)
                 ->setOpeCelular($request->get('celular'))
                 ->setOpeCorreo($request->get('correo'))
                 ->setUsuario($usuario)
                 ->setOpeVisible(true);
        $em->persist($operador);
        $em->flush();
        return $this->serializedResponse($operador, $groups);
    }
    
    public function patchEmpresasOperadoresAction(Request $request, $idEmpresa, Operador $operador ){
        $groups =['operador_detalle'];
        $em = $this->getDoctrine()->getManager();

        $rut = str_replace('.','', str_replace('-', '', $request->get('rut')));   
        $operador->setOpeNombre($request->get('nombre'))
                ->setOpeApellido($request->get('apellido'))
                ->setOpeRut($rut)
                ->setOpeLicencia($request->get('licencia'))
                ->setOpeCorreo($request->get('correo'))
                ->setOpeCelular($request->get('celular'))
                ->setOpeVisible($request->get('visible'));
        $em->persist($operador);
        $em->flush();

        $usuario = $operador->getUsuario();
        $usuario->setVisible($request->get('visible'));
        $em->persist($usuario);
        $em->flush();

        return $this->serializedResponse($operador, $groups);   
    }
}
