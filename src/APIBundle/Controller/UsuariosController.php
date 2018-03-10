<?php

namespace APIBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuariosController extends APIBaseController
{
    /**
    * Lista de usuarios
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function getUsuariosAction(Request $request){
        $groups = ['usuario_lista','rol_detalle','empresa_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $usuarios = $this->getDoctrine()->getRepository('AppBundle:User')->buscarSoloUsuariosVisibles();
        return $this->serializedResponse($usuarios, $groups);
    }
    
    /**
    * Agregar usuario
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function postUsuariosAction(Request $request){  
        //$groups ='';
        $error['data']['message'] = '';
        //Verificar que no existe el usuario
        $usuario = $this->getDoctrine()->getRepository('AppBundle:User')->verificarQueNoExistaElUsuario($request->get('username'));
        if(count($usuario) == 0){
            $empresa  = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($request->get('idempresa')); 
            if($empresa->getId() == 1){
               $idrol = 1; 
            }else{
                $idrol = 2;
            }
            $rol   = $this->getDoctrine()->getRepository('AppBundle:Rol')->find($idrol); 
            $token = $this->getDoctrine()->getRepository('AppBundle:User')->obtenerTokenParaElUsuario();
            
            $usuario = new User();
            $pass = $this->container->get('security.password_encoder');
            $password = $pass->encodePassword($usuario, $request->get('password'));
            
            $usuario->setEmpresa($empresa);
            $usuario->setRol($rol);
            $usuario->setUsername($request->get('username'));
            $usuario->setPassword($password);
            $usuario->setToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            //return $this->serializedResponse($usuario, $groups);
            return new Response( json_encode($error) );
        }else{
            $error['data']['message'] = 'El username ya existe, intente con otro nombre.';
            return new Response( json_encode($error) );
        }
    }
    
    /**
    * Editar usuario
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function patchUsuariosAction(Request $request, User $usuario){
        $groups =['usuario_detalle'];
        if($request->get('password')){
            $pass = $this->container->get('security.password_encoder');
            $password = $pass->encodePassword($usuario, $request->get('password'));
            $usuario->setPassword($password);
        }
        $usuario->setVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();
        return $this->serializedResponse($usuario, $groups);
    }
}
