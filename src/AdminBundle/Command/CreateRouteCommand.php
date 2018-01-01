<?php

namespace AdminBundle\Command;

use AppBundle\Entity\Ruta;
use AppBundle\Entity\RutaDetalle;
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

        if($fs->exists($absolutePath."data/out.txt"))
        {
            $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

            //Buscar proceso en espera de ejecucion.
            $proceso = $manager->getRepository("AppBundle:Proceso")->procesoEnEsperaDeEjecucion(1,1);
            if( count($proceso) > 0)
            {
                $cantClientes = $proceso[0]->getPrcCantidadClientes();
        
                $planificacion = $camiones = $trabajo = $datos = [];
                $camion = $l = 0;
                $caracter = ['y','[','*',',',']'];
                $replace  = ['','','','',''];

                // Leer una vez el archivo para obtener posicion de los datos que necesitamos
                $file = fopen($absolutePath."data/out.txt",'r');
                while(!feof($file)){
                    $l++;
                    $linea = fgets($file);
                    $viene = strpos($linea, '[*,*,');
                    if($viene !== false)
                    { 
                       $camion= (int)str_replace($caracter, $replace, $linea);
                       $desde = ($l+1);
                       $hasta = ($desde+($cantClientes*2)+2);
                       $datos = ["Camion"=>$camion, "Desde"=>$desde,"Hasta"=>$hasta];
                       array_push($camiones,$datos);
                    }
                }
                fclose($file);


                // Con los datos identificados anteriormente, abrir nuevamente el archivo y extraer la información
                $datos = $routes = $visitas = [];
                foreach ($camiones as $camion => $c)
                {
                    $file = fopen($absolutePath."data/out.txt",'r');
                    $l=0;
                    $visitas = [];
                    $routes[$c['Camion']] = []; 

                    while (!feof($file))
                    {
                        $l++;
                        $linea = fgets($file);
                        if( ($l >= $c['Desde']) && ($l<=$c['Hasta'])  )
                        {       
                            $dias1a19 = strpos($linea, ':    1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19 :=');
                            $dia20 = strpos($linea, ':   20    :=');
                            if(($dias1a19 === false) && ($dia20 === false))
                            {
                                if(trim($linea) != "")
                                {
                                    $cliente = trim(substr($linea, 0,2));
                                    if(strlen( trim($linea))> 10)
                                    {
                                        $d1 = (int)trim(substr($linea, 5,1));
                                        $d2 = (int)trim(substr($linea, 9,1));
                                        $d3 = (int)trim(substr($linea, 13,1));
                                        $d4 = (int)trim(substr($linea, 17,1));
                                        $d5 = (int)trim(substr($linea, 21,1));
                                        $d6 = (int)trim(substr($linea, 25,1));
                                        $d7 = (int)trim(substr($linea, 29,1));
                                        $d8 = (int)trim(substr($linea, 33,1));
                                        $d9 = (int)trim(substr($linea, 37,1));
                                        $d10= (int)trim(substr($linea, 41,1));
                                        $d11= (int)trim(substr($linea, 45,1));
                                        $d12= (int)trim(substr($linea, 49,1));
                                        $d13= (int)trim(substr($linea, 53,1));
                                        $d14= (int)trim(substr($linea, 57,1));
                                        $d15= (int)trim(substr($linea, 61,1));
                                        $d16= (int)trim(substr($linea, 65,1));
                                        $d17= (int)trim(substr($linea, 69,1));
                                        $d18= (int)trim(substr($linea, 73,1));
                                        $d19= (int)trim(substr($linea, 77,1));
                                        $datos = array("Cliente"=>$cliente,1=>$d1,2=>$d2,3=>$d3,4=>$d4,5=>$d5,6=>$d6,7=>$d7,8=>$d8,9=>$d9,10=>$d10,11=>$d11,12=>$d12,13=>$d13,14=>$d14,15=>$d15,16=>$d16,17=>$d17,18=>$d18,19=>$d19,20=>0);
                                        array_push($visitas,$datos);
                                    }else{
                                        foreach($visitas as $visita=>$v){
                                            if($v['Cliente'] == $cliente){
                                                $visitas[$visita][20] = (int)trim(substr($linea, 5,1)) ;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                       $routes[$c['Camion']] = $visitas;
                    }
                    fclose($file);
                }


                // Identificar fechas de dias habiles donde se cargará la información
                $hoy = date('Y-m-d');
                $prox20dias =date('Y-m-d', strtotime('+30 day'));
                $inicio = strtotime($hoy); 
                $fin    = strtotime($prox20dias);

                $fechas = [];
                $i=1;
                for($inicio;$inicio<=$fin;$inicio=strtotime('+1 day ' . date('Y-m-d',$inicio)))
                {
                    if(date('D',$inicio) != 'Sun' && date('D',$inicio)!='Sat'):
                        $fechas[$i] = $inicio;
                        $i++;
                    endif;

                    if($i>20):
                        break;
                    endif;
                }

                // La información extraida del archivo, se registra en la base de datos con las fechas indentificadas
                foreach($routes as $route => $visitas)
                {
                    $camion = $manager->getRepository("AppBundle:Camion")->find($route);
                    foreach($visitas as $visita):

                        $idcliente = $visita['Cliente'];
                        $datos = [];

                        for($d=1;$d<=20;$d++):
                            $datos[$d] = $visita[$d];
                        endfor;
    
                        if(in_array(1, $datos)):

                            for($d=1;$d<=20;$d++):

                                $ruta = $manager->getRepository("AppBundle:Ruta")->buscarRutasDelDiaPorCamionYOperador(date('Y-m-d',$fechas[$d]),$proceso[0]->getEmpresa(),$camion->getId(),$camion->getOperador());
                                
                                if($datos[$d]):
                                
                                    $titulo= 'Ruta de trabajo operador - '.$camion->getOperador()->getId().''/*.date('d/m/Y',$fechas[$d])*/;
                                    
                                    $cliente = $manager->getRepository("AppBundle:Cliente")->find($idcliente);
                                    
                                    if(count($ruta) == 0):
                                        $ruta = new Ruta();
                                    else:
                                        $ruta = $ruta[0];
                                    endif;
                                   
                                    $ruta->setRtaTitulo($titulo)
                                         ->setRtaFecha(new \DateTime(date('Y-m-d H:s:i',$fechas[$d])))
                                         ->setProceso($proceso[0])
                                         ->setOperador($camion->getOperador())
                                         ->setCamion($camion);
                                    $manager->persist($ruta);
                                    $manager->flush();


                                    $rutaDetalle = $manager->getRepository("AppBundle:RutaDetalle")->findBy( array('ruta'=>$ruta,'cliente'=>$cliente) );

                                    if(count($rutaDetalle) == 0):
                                        $rutaDetalle = new RutaDetalle();
                                    else:
                                        $rutaDetalle = $rutaDetalle[0];
                                    endif;

                                    $rutaDetalle->setRdeLongitud($cliente->getCliLongitud())
                                                ->setRdeLatitud($cliente->getCliLatitud())
                                                ->setRdeEstado(0)
                                                ->setRdeComentario('')
                                                ->setRuta($ruta)
                                                ->setCliente($cliente);
                                    $manager->persist($rutaDetalle);
                                    $manager->flush();

                                else:

                                    if(count($ruta) > 0): 

                                        $ruta = $ruta[0];
                                        $rutaDetalle = $manager->getRepository("AppBundle:RutaDetalle")->findBy( array('ruta'=>$ruta,'cliente'=>$cliente) );
                                        if(count($rutaDetalle) > 0):
                                            $rutaDetalle = $rutaDetalle[0];
                                            $manager->remove($rutaDetalle);
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
                        endif;
                    endforeach;
                }

                $output->writeln("Carga de datos finalizada, ahora puede ejecutar comando sarc:terminate-process", FILE_APPEND);


                $command = $this->getApplication()->find('sarc:terminate-process');
                $arguments = array(
                    'command'   => 'sarc:terminate-process'
                );
                //obtnemos los parametros del comando
                $greetInput = new ArrayInput($arguments);
                //ejecutamos el comando
                $returnCode = $command->run($greetInput, $output);


            }else{
                $output->writeln("No existen proceso en ejecución", FILE_APPEND);
            }
        }else{
            $output->writeln("El archivo de salida no existe", FILE_APPEND);
        }
    }
}