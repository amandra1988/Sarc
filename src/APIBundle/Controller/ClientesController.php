<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
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
        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')->findBy(array('empresa'=>$idEmpresa,'cliVisible'=>1));
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

    public function postEmpresasClientesAction(Request $request, Empresa $empresa){
        $groups ='';
        $frecuencia = $this->getDoctrine()->getRepository('AppBundle:Frecuencia')->find($request->get('frecuencia'));
        $comuna = $this->getDoctrine()->getRepository('AppBundle:Comuna')->find($request->get('comuna'));
        
        $cliente = new Cliente();
        $cliente->setCliNombre($request->get('nombre'))->setCliDireccion($request->get('direccion'))
        ->setCliNumero($request->get('numero'))->setCliCelular($request->get('celular'))->setCliCorreo($request->get('correo'))
        ->setCliTelefono($request->get('telefono'))->setFrecuencia($frecuencia)->setCliDemanda($request->get('demanda'))
        ->setComuna($comuna)->setEmpresa($empresa)->setCliVisible($request->get('visible'));
    
        $direccion = $request->get('direccion').' '.$request->get('numero').', '.$comuna->getComNombre().', Chile';
        $coordenadas = $this->getDoctrine()->getRepository('AppBundle:CentroDeAcopio')->obtenerLatitudYLongitud($direccion);
        $cliente->setCliLatitud($coordenadas['latitud'])->setCliLongitud($coordenadas['longitud']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

/*  ==============================================================================================================
            EXTRA
                Al crear cliente, se agrega a una ruta detalle para generar datos para el calendario
                Esta funcionalidad es temporal.
    ==============================================================================================================
*/
        // Obtener ruta del dia
        $dia  = date('d');
        $anio = date('Y');
        $mes  = date('m');

        $ruta= $this->getDoctrine()->getRepository('AppBundle:Ruta')->buscarRutasDelDia($dia,$mes,$anio,$empresa->getId());
        if(count($ruta) == 0){
            // Crear la ruta
            $proceso = $this->getDoctrine()->getRepository('AppBundle:Proceso')->find(1);
            $operador= $this->getDoctrine()->getRepository('AppBundle:Operador')->find(1);

            $ruta = new Ruta();
            $ruta->setRtaTitulo('Ruta '.$dia.'/'.$mes.'/'.$anio)->setRtaFecha( new \DateTime(date('Y-m-d')) )
            ->setProceso($proceso)->setOperador($operador)->setCamion($operador->getCamion());

            $em = $this->getDoctrine()->getManager();
            $em->persist($ruta);
            $em->flush();
        }else{
            $ruta = $ruta[0];
        }
        // Crear ruta detalle
        $rutadetalle = new RutaDetalle();
        $rutadetalle->setCliente($cliente)->setRdeLongitud($cliente->getCliLongitud())->setRdeLatitud($cliente->getCliLatitud())->setRuta($ruta)->setRdeEstado(0)->setRdeComentario('-');
        $em = $this->getDoctrine()->getManager();
        $em->persist($rutadetalle);
        $em->flush();

/*  ==============================================================================================================
    ==============================================================================================================
*/
        return $this->serializedResponse($cliente, $groups);
    }
}
