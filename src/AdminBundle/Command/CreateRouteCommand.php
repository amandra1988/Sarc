<?php

namespace AdminBundle\Command;

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

        if($fs->exists($absolutePath."data/out.txt")){
         
            $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');
            //Buscar proceso en procesod de ejecucion.
            $proceso = $manager->getRepository("AppBundle:Proceso")->procesoEnEsperaDeEjecucion(1,1);
            
            if( count($proceso) > 0){

                $cantClientes = $proceso[0]->getPrcCantidadClientes();

                $file = fopen($absolutePath."data/out.txt",'r');
                $l=0;
                $camiones=[];
                $camion  =0;
                $caracter = ['y','[','*',',',']'];
                $replace  = ['','','','',''];

                while(!feof($file)) {

                    $l++;
                    $linea = fgets($file);
                    $viene = strpos($linea, '[*,*,');
                    if( $viene !== false)
                    { 
                       $camion = (int)str_replace($caracter, $replace, $linea);
                       $desde = ($l+1);
                       $hasta = ($desde+($cantClientes*2)+2);
                       $datos = [ "Camion"=>$camion, "Desde"=>$desde,"Hasta"=>$hasta];
                       array_push($camiones,$datos);
                    }
                }

                dump($camiones); die;

                // $output->writeln("El archivo de salida no existe", FILE_APPEND);
                           
            }else{
                $output->writeln("No existen proceso en ejecución", FILE_APPEND);
            }
        }else{
            $output->writeln("El archivo de salida no existe", FILE_APPEND);
        }
    }
}