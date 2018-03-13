<?php

namespace AdminBundle\Command;

use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
use AppBundle\Entity\Feriados;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;


class CreateRouteCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sarc:create-route';

    public function __construct()
    {    
        // you *must* call the parent constructor
        parent::__construct();
    }
    protected function configure()
    {
        $this
        ->setName('sarc:create-route')
        ->setDescription('Command to read content from the output file and load it into the DB.')
        ->setHelp('This command allows to read contents of a .solid file and load it into the DB to generate the work paths')   
        ->addArgument('file_name', InputArgument::OPTIONAL, 'You need pass name of file');
    }
  
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $fs = new Filesystem();
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');
        
        $fileName = $input->getArgument('file_name');

        $archivo = explode(".", $fileName);
        $nfile = $archivo[0];
        
        $proceso = explode("_",$nfile);
        $idProceso = $proceso[0];

        $logger = $this->getContainer()->get('logger');
        $logger->info('SARC: Crear ruta '.$fileName);


        if($fs->exists($absolutePath."data/".$nfile.".sol"))
        {

            $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');
            $proceso = $manager->getRepository("AppBundle:Proceso")->find($idProceso);
            $configAmpl =   $manager
                            ->getRepository("AppBundle:ConfiguracionAmpl")
                            ->findBy(
                              [
                                  'empresa'=>$proceso->getEmpresa()->getId()
                              ]);
            $totalDias =  $configAmpl[0]->getDias();
            $camiones = $trabajo = $datos = [];
            $camion = $l = 0;
            $caracter = ['y','[','*',',',']'];
            $replace  = ['','','','',''];
            
            $file = fopen($absolutePath."data/".$nfile.".sol", "r");
           
            while(!feof($file)){
                $l++;
                $linea = fgets($file);
                if(strpos($linea, '[*,*,') !== false)
                { 
                   $camion= (int)str_replace($caracter, $replace, $linea);
                   $desde = ($l+1);
                   $hasta = ($desde + $totalDias);  
                   $datos = ["Camion"=>$camion, "Desde"=>$desde,"Hasta"=>$hasta];
                   array_push($camiones,$datos);
                }
            }
            fclose($file);


// Con los datos identificados anteriormente, abrir nuevamente el archivo y extraer la información

            $datos = $routes = $visitas = [];

            foreach ($camiones as $camion => $c):
            
                $file = fopen($absolutePath."data/".$nfile.".sol",'r');
                $l=0;
                $visitas = $jornadas = $jor= $clientes = [];
                $routes[$c['Camion']] = [];
                $dia = 0;

                while(!feof($file)):
                    $l++;
                    $linea = fgets($file);
                    
                    if(($l>=$c['Desde']) && ($l<=$c['Hasta'])):
                        
                        if(strpos($linea, ':') !== false):
                            // Son los títulos con los correlativos de los clientes.
                            $caracter = ['    ','   ',':','='];
                            $replace  = ['',',','',''];
                            $linea = str_replace($caracter, $replace, $linea);
                            $clientes['Clientes'] = explode(',', $linea);
                        else:     
                            // Son los dias de trabajo.
                            $dia++;
                            $caracter = ['   ',':','='];
                            $replace  = [',','',''];
                            $linea = str_replace($caracter, $replace, $linea);
                            
                            $jornada =  explode(',', $linea);
                            foreach ($jornada as $key => $value): 
                                if($key >0)
                                    $jor[$key] = (int)$value;
                                
                            endforeach;
                            $jornadas['dia'][$dia] = $jor;
                        endif;
                        
                    endif;
                   $routes[$c['Camion']] = ['Clientes'=>$clientes, 'Jornadas'=> $jornadas];
                endwhile;
                fclose($file);
            endforeach;


// Identificar fechas de dias habiles donde se cargará la información


            $hoy = date('Y-m-d');
            $prox20dias =date('Y-m-d', strtotime('+30 day'));
            $inicio = strtotime($hoy);                
            $fin    = strtotime($prox20dias);
            $fechas = [];
            $i=1;         
            for($inicio;$inicio<=$fin;$inicio=strtotime('+1 day ' . date('Y-m-d',$inicio))):

                $feriado = $manager
                    ->getRepository("AppBundle:Feriados")
                    ->findBy( array("fecha"=>new \DateTime(date('Y-m-d',$inicio)) ));

                $esFeriado = (count($feriado)>0)?true:false;

                if(date('D',$inicio) != 'Sun' && date('D',$inicio)!='Sat' && !$esFeriado):

                    $fechas[$i] = $inicio;
                    $i++;
                endif;
                if($i>$totalDias) break;
            endfor;


// La información extraida del archivo, se registra en la base de datos con las fechas indentificadas

            $informeTotalClientesProcesados = 0;
            $informeCamiones = [];
            $totalVisitas = [];
            $frecuencia = [1=>20, 2=>4, 3=>8, 4=>12, 5=>2, 6=>1];
            $criterioDeExito = [1=>1, 2=>5, 3=>3, 4=>2, 5=>10, 6=>20];
            /*
                '1'=>'Diaria'     : (20/20) = round(1)
                '2'=>'Semanal'    : (20/4)  = round(5)
                '3'=>'Bisemanal'  : (20/8)  = round(2.5)    => 3
                '4'=>'Trisemanal' : (20/12) = round(1.6667) => 2
                '5'=>'Quincenal'  : (20/2)  = round(1) =10
                '6'=>'Mensual'    : (20/1)  = round(1) =20
            */


            foreach($routes as $key => $visitas):
                
                $correlativoCam = $key;
            
                //Con el correlativo del camion y el n° de proceso buscar idCamion
                $procesoCamion = $manager
                                 ->getRepository("AppBundle:ProcesoCamiones")
                                 ->findBy(['pcmOrden'=>$correlativoCam, 'proceso'=>$idProceso]);
                $camion = $procesoCamion[0]->getCamion();

                $clientes = $visitas['Clientes'];
                $jornadas = $visitas['Jornadas'];

                $informeCamionClientes =[];
                $totalDemanda = 0;

                foreach($clientes as $clie):

                    $informeTotalCumplidos = 0;

                    $informeTotalClientesProcesados = count($clie);

                    foreach($clie as $c):

                        $correlativoClie = (int)$c;

                         //Con el correlativo del cliente y el n° de proceso buscar idCliente
                        $procesoCliente = $manager
                                          ->getRepository("AppBundle:ProcesoClientes")
                                          ->findBy(['pclOrden'=>$correlativoClie, 'proceso'=>$idProceso]);
                        
                        $cliente = $procesoCliente[0]->getCliente();

                        for($dia=1; $dia<=$totalDias; $dia++):

                            $trabajo = $jornadas['dia'][$dia][$correlativoClie];
                        
                            $ruta = $manager->getRepository("AppBundle:Ruta")
                                            ->buscarRutasDelDiaPorCamionYOperador(
                                                    date('Y-m-d',$fechas[$dia]),
                                                    $proceso->getEmpresa(),
                                                    $camion->getId(),
                                                    $camion->getOperador()
                                            );

                            if($trabajo):

                                if( !in_array($cliente->getId(), $informeCamionClientes) ){
                                    array_push($informeCamionClientes, $cliente->getId());
                                    $totalDemanda+= $cliente->getCliDemanda();
                                }

                                if( !isset($totalVisitas[$cliente->getId()])){
                                    $totalVisitas[$cliente->getId()] = 1;
                                }else{
                                    $totalVisitas[$cliente->getId()] = (int)$totalVisitas[$cliente->getId()]+1;
                                }

                                $titulo= 'Ruta de trabajo '.date('d/m/Y',$fechas[$dia]) .' [OP:'.$camion->getOperador()->getId().']';
                                $ruta =(count($ruta) == 0)? new Ruta(): $ruta[0] ;

                                $fecha = new \DateTime(date('Y-m-d H:s:i',$fechas[$dia]));

                                $ruta ->setRtaTitulo($titulo)->setRtaFecha($fecha)->setProceso($proceso)->setOperador($camion->getOperador())->setCamion($camion);
                                $manager->persist($ruta);
                                $manager->flush();

                                $rutaDetalle = $manager->getRepository("AppBundle:RutaDetalle")->findBy( array('ruta'=>$ruta,'cliente'=>$cliente) );

                                $rutaDetalle =(count($rutaDetalle)==0)? new RutaDetalle() : $rutaDetalle[0];

                                $rutaDetalle->setRdeLongitud($cliente->getCliLongitud())->setRdeLatitud($cliente->getCliLatitud())->setRdeEstado(0)->setRdeComentario('')->setRuta($ruta)->setCliente($cliente);
                                $manager->persist($rutaDetalle);
                                $manager->flush();

                            else:

                                if(count($ruta) > 0):

                                    $ruta = $ruta[0];
                                
                                    $rutaDetalle = $manager->getRepository("AppBundle:RutaDetalle")->findBy( array('ruta'=>$ruta,'cliente'=>$cliente) );

                                    if(count($rutaDetalle) > 0):
                                            $manager->remove($rutaDetalle[0]);
                                            $manager->flush();
                                    endif;

                                    // Si la ruta no tiene visitas asociadas, la borro.
                                    $rutaDetalle = $manager->getRepository("AppBundle:RutaDetalle")->findBy( array('ruta'=>$ruta) );
                                    if(count($rutaDetalle) == 0):
                                        $manager->remove($ruta);
                                        $manager->flush();
                                    endif;

                                endif;
                                
                            endif;

                        endfor;

                        if( !isset($informeClientes[$cliente->getId()]))
                            $informeClientes[$cliente->getId()] = [];


                        if(isset($totalVisitas[$cliente->getId()])):

                            $metrica = (int)round( ($totalDias/$totalVisitas[$cliente->getId()]) );
                            $a = $metrica;
                            $b = $criterioDeExito[$frecuencia[$cliente->getFrecuencia()->getId()]];
                            $cumplido = false;

                            if($b == $a):
                                $cumplido = true;
                                $informeTotalCumplidos++;
                            endif;
                        else:

                            $cumplido =false;
                            $metrica = 0;
                        endif;

                        $informeClientes[$cliente->getId()] = [
                            "id"=>$cliente->getId(),
                            "correlativo"=>$correlativoClie,
                            "frecuencia"=>$cliente->getFrecuencia()->getNombre(),
                            "cantVisitasGeneradas"=>(isset($totalVisitas[$cliente->getId()]))?$totalVisitas[$cliente->getId()]:0,
                            "visitasEsperadas"=>$frecuencia[$cliente->getFrecuencia()->getId()],
                            "criterioDeExito"=>$metrica,
                            "cumplido"=>$cumplido
                        ];

                    endforeach;
                endforeach;

                if( !isset($informeCamiones[$camion->getId()]) )
                    $informeCamiones[$camion->getId()] = [
                            "id"=>$camion->getId(),
                            "correlativo"=>$correlativoCam,
                            "clientes"=>$informeCamionClientes,
                            "totalDemanda"=>$totalDemanda,
                            "capacidadCamion"=>$camion->getCamCapacidad()
                        ];

            endforeach;


            $informeResultados = [
                        "total_clientes"=> $proceso->getPrcCantidadClientes(),
                        "total_clientes_procesados"=>$informeTotalClientesProcesados,
                        "cumplidos"=> $informeTotalCumplidos.'/'.$informeTotalClientesProcesados,
                        "porcentajeCumplimiento"=>(int)round($informeTotalCumplidos * 100 / $informeTotalClientesProcesados)."%",
                        "camiones" => $informeCamiones,
                        "clientes" => $informeClientes
                    ];


            $informeResultados =  $this->getContainer()->get('twig')
                ->render('AdminBundle:Data:resultados.html.twig',
                    $informeResultados
                );

            //abrimos el archivo para agregar los contenidos
            file_put_contents($absolutePath."data/".$nfile."_resultados.txt", $informeResultados);

            $output->writeln("Carga de datos finalizada, ahora puede ejecutar comando sarc:terminate-process", FILE_APPEND);

            $command = $this->getApplication()->find('sarc:terminate-process');

            $arguments = array(
                'command'   => 'sarc:terminate-process',
                'file_name' => $fileName
            );

            $greetInput = new ArrayInput($arguments);

            $command->run($greetInput, $output);
        }else{
            $output->writeln("El archivo de salida no existe", FILE_APPEND);
        }
    }
}