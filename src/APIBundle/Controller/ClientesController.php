<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\User;
use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
use AppBundle\Entity\Proceso;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientesController extends APIBaseController
{
    /**
    * Obtener lista de clientes de la empresa
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasClientesAction(Request $request, $idEmpresa){
        $groups = ['cliente_lista','r_cliente_comuna','comuna_detalle','frecuencia_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')->obtenerClientesDeLaEmpresa($idEmpresa);
        return $this->serializedResponse($clientes, $groups); 
    }
    /**
    * Editar Cliente
    * @return Response La respuesta serializada
    */
    public function patchEmpresasClientesAction(Request $request,Empresa $empresa, Cliente $cliente ){  
        
        $groups =['cliente_detalle'];

        $em = $this->getDoctrine()->getManager();

        if($request->get('visible')){
            
            $theta = 0;
            
            $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
            $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));

            $cliente->setCliNombre($request->get('nombre'))
                    ->setCliDireccion($request->get('direccion'))
                    ->setCliCelular($request->get('celular'))
                    ->setCliCorreo($request->get('correo'))
                    ->setCliTelefono($request->get('telefono'))
                    ->setFrecuencia($frecuencia)
                    ->setCliDemanda($request->get('demanda'))
                    ->setComuna($comuna);

            $direccion   = $request->get('direccion').', '.$comuna->getComNombre().', Chile';
            $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);

            $latitud = $coordenadas['latitud'];
            $longitud= $coordenadas['longitud'];

            $geotools   = new \League\Geotools\Geotools();
            $cooCliente = new \League\Geotools\Coordinate\Coordinate([$latitud, $longitud]);

            $cClie = $geotools->convert($cooCliente);
            $cCliente = explode(" ",$cClie->toUTM());

            $xclie = ($cCliente[1] / -9.99);
            $yclie = $cCliente[2];

            $xdep = $empresa->getCentroDeAcopio()->getCenX();
            $ydep = $empresa->getCentroDeAcopio()->getCenY();

            $atan2 = atan2( ($yclie - $ydep), ($xclie - $xdep));
            $theta = rad2deg($atan2);

            $cliente->setCliLatitud($latitud)
                    ->setCliLongitud($longitud)
                    ->setCliY($yclie)
                    ->setCliX($xclie)
                    ->setCliTheta($theta);
   
        }

        $cliente->setCliVisible($request->get('visible'));
        $em->persist($cliente);
        $em->flush();

        $clientes = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:Cliente')
                    ->obtenerClientesDeLaEmpresa($empresa->getId());

        $this->getDoctrine()
             ->getRepository('AppBundle:Proceso')
             ->agregarActualizarProceso($empresa,$clientes);

        return  $this->serializedResponse($cliente, $groups) ;
    }

    public function postEmpresasClientesAction(Request $request, Empresa $empresa){

        $groups=['cliente_detalle'];

        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia')); 
        $comuna     = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));

        $direccion   = $request->get('direccion').', '.$comuna->getComNombre().', Chile';
        
        $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);
               
        $theta = 0;

        $em = $this->getDoctrine()->getManager();

        $cliente = new Cliente();

        $cliente->setCliNombre($request->get('nombre'))
                ->setCliDireccion($request->get('direccion'))
                ->setCliCelular($request->get('celular'))
                ->setCliCorreo($request->get('correo'))
                ->setCliTelefono($request->get('telefono'))
                ->setFrecuencia($frecuencia)
                ->setCliDemanda(str_replace(",",".",$request->get('demanda')))
                ->setComuna($comuna)
                ->setCliVisible($request->get('visible'));

        $latitud = $coordenadas['latitud'];
        $longitud= $coordenadas['longitud'];

        $geotools   = new \League\Geotools\Geotools();
        $cooCliente = new \League\Geotools\Coordinate\Coordinate([$latitud, $longitud]);

        $cClie = $geotools->convert($cooCliente);
        $cCliente = explode(" ",$cClie->toUTM());

        $xclie = ($cCliente[1] / -9.99);
        $yclie = $cCliente[2];

        $xdep = $empresa->getCentroDeAcopio()->getCenX();
        $ydep = $empresa->getCentroDeAcopio()->getCenY();

        $atan2 = atan2( ($yclie - $ydep), ($xclie - $xdep));
        $theta = rad2deg($atan2);

        $cliente->setCliLatitud($latitud)
                ->setCliLongitud($longitud)
                ->setCliY($yclie)
                ->setCliX($xclie)
                ->setCliTheta($theta);

        $em->persist($cliente);
        $em->flush();

        $usuario = new User();
        $rol   = $this->getDoctrine()->getRepository('AppBundle:Rol')->find(3);
        $token = $this->getDoctrine()->getRepository('AppBundle:User')->obtenerTokenParaElUsuario();
        
        $username = "cliente-".$cliente->getId();
        $pass = $this->container->get('security.password_encoder');
        $password = $pass->encodePassword($usuario,12345);
        
        $usuario->setEmpresa($empresa)
                ->setRol($rol)
                ->setUsername($username)
                ->setPassword($password)
                ->setToken($token);
        $em->persist($usuario);

        $cliente->setUsuario($usuario);
        $em->persist($cliente);
        $em->flush();

        $clientes = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:Cliente')
                    ->obtenerClientesDeLaEmpresa($empresa->getId());

        $this->getDoctrine()
             ->getRepository('AppBundle:Proceso')
             ->agregarActualizarProceso($empresa,$clientes);
        
        return $this->serializedResponse($cliente, $groups);
    }
}