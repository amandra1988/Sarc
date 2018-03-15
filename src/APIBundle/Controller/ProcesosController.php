<?php

namespace APIBundle\Controller;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

use Symfony\Component\HttpKernel\KernelInterface;

class ProcesosController extends APIBaseController
{
    
    /**
    * Lista de procesos
    * @param Request $request La petición
    * @return Response La respuesta serializada
    */
    public function getEmpresasProcesosAction(Request $request,Empresa $empresa){

        $groups = ['proceso_detalle','r_procesos_region','region_detalle'];

        if(is_array($request->get('expand'))){
            $groups = array_merge($groups, $request->get('expand'));
        }
        $procesos = $this->getDoctrine()->getRepository('AppBundle:Proceso')->obtenerProcesosDeLaEmpresa($empresa->getId());
        return $this->serializedResponse($procesos, $groups);
    }

    public function postEmpresasProcesosAction(Request $request,Empresa $empresa){

        $groups = '';
        $respuesta=[];
        $logger = $this->container->get('logger');




        try {

            if($request->get('accion') == 1){

                $region = NULL;

                if($request->get('region')){
                    $region = $this->getDoctrine()->getRepository('AppBundle:Region')->find($request->get('region'));
                }

                $clientes= $this->getDoctrine()->getRepository('AppBundle:Cliente')->obtenerClientesDeLaEmpresa($empresa,$region);

                if(count($clientes) ==  0){
                    $respuesta['mensaje'] = "No existen clientes " ;

                    if($region)
                        $respuesta['mensaje'] .= "en la ". $region->getRegNombre();

                    $respuesta['mensaje'] .= ". No es posible crear el proceso.";

                }else{
                    $respuesta['mensaje'] = $this->getDoctrine()->getRepository('AppBundle:Proceso')->agregarActualizarProceso($empresa,$clientes,$region);
                }

            }else{

                $error ='';
                if( $request->get('proceso') )
                {
                    $id = $request->get('proceso');
                    $proceso = $this->getDoctrine()->getRepository("AppBundle:Proceso")->find($id);

                    if(count($proceso)){

                        $fecha = date('dmY') ;
                        $fileName = $proceso->getId().'_'.$fecha;
                        $command = $this->get('create.command');
                        $input = new ArrayInput(array(
                            'file_name' =>  $fileName
                        ));
                        $output = new BufferedOutput();
                        $command->run($input,$output);
                        $content = $output->fetch();

                    }else{
                        $content = 'No existe proceso con estado "En espera" y validado.';
                    }
                    $respuesta['mensaje'] = $content;
                }else{
                    $respuesta['mensaje'] = "Falta el código del proceso a ejecutar";
                }
            }
        }
        catch(Exception $e) {
            $respuesta['mensaje'] = $e->getMessage();
        }
        return $this->serializedResponse($respuesta, $groups);
    }

    public function patchEmpresasProcesosAction(Request $request,Empresa $empresa){

        $groups = ['proceso_detalle'];

        $proceso = $this->getDoctrine()->getRepository('AppBundle:Proceso')->find($request->get('idproceso'));

        $proceso->setPrcValidado($request->get('validar'));
        if($request->get('validar')){
            $proceso->setPrcObservacion('Proceso validado y a la espera de ejecución');
        }else{
            $proceso->setPrcObservacion('Debe validar este proceso para que pueda ser ejecutado.');
        }
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($proceso);
        $em->flush();

        return $this->serializedResponse($proceso, $groups);
    }
}