<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientesController extends APIBaseController
{
    /**
    * Obtener lista de operadores
    * @return Response La respuesta serializada
    */ 
    public function getEmpresasClientesAction(Request $request, $idEmpresa){
        
        $groups = ['cliente_lista','comuna_detalle','frecuencia_detalle'];
        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')->buscarSoloClientesVisibles($idEmpresa);
        return $this->serializedResponse($clientes, $groups); 
    }

    /**
     *  Editar Cliente
     * @return Response La respuesta serializada
     */
    public function patchEmpresasClientesAction(Request $request, $idEmpresa, Cliente $cliente ){
        $groups ='';
        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
        $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));
        $cliente->setCliNombre($request->get('nombre'))
            ->setCliDireccion($request->get('direccion'))
            ->setCliNumero($request->get('numero'))
            ->setCliCelular($request->get('celular'))
            ->setCliCorreo($request->get('correo'))
            ->setCliTelefono($request->get('telefono'))
            ->setFrecuencia($frecuencia)
            ->setCliDemanda($request->get('demanda'))
            ->setComuna($comuna)
            ->setCliVisible($request->get('visible'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();
        return $this->serializedResponse($cliente, $groups);
    }

    public function postEmpresasClientesAction(Request $request, $idEmpresa){
        $groups ='';
        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
        $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));
        $cliente = new Cliente();
        $cliente->setCliNombre($request->get('nombre'))
                ->setCliDireccion($request->get('direccion'))
                ->setCliNumero($request->get('numero'))
                ->setCliCelular($request->get('celular'))
                ->setCliCorreo($request->get('correo'))
                ->setCliTelefono($request->get('telefono'))
                ->setFrecuencia($frecuencia)
                ->setCliDemanda($request->get('demanda'))
                ->setComuna($comuna)
                ->setCliVisible($request->get('visible'));

        $direccion = $request->get('direccion').' '.$request->get('numero').', '.$comuna->getComNombre().', Chile';
        $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);
        $latitud = $coordenadas['latitud'];
        $longitud= $coordenadas['longitud'];
        $cliente->setCliLatitud($latitud);
        $cliente->setCliLongitud($longitud);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();
        return $this->serializedResponse($cliente, $groups);

    }
}
