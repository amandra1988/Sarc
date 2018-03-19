<?php

namespace AdminBundle\Command;

use AppBundle\Entity\ProcesoClientes;
use AppBundle\Entity\ProcesoCamiones;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CreateDataFileCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sarc:create-data-file';
    public function __construct()
    {
    
        // you *must* call the parent constructor
        parent::__construct();
    }
    protected function configure()
    {
        $this
        ->setName('sarc:create-data-file')
        ->setDescription('Creates data file for procesing client routes.')
        ->setHelp('This command allows create a data file to procesing cliente route')
        ->addArgument('file_name', InputArgument::OPTIONAL, 'You need pass name of file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        $fileName = $input->getArgument('file_name');
        $parte = explode("_",$fileName);

        $idproceso = $parte[0];

        //obtenemos la ruta del modulo AdminBundle
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');

        //validamos que exista la carpeta data
        if(!$fs->exists($absolutePath."data")){
            try {
                $fs->mkdir($this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/')."data");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }

        //siempre borramos el archivo, temas cache
        if($fs->exists($absolutePath."data/".$fileName.".dat")){
            unlink($absolutePath."data/".$fileName.".dat");
        }
        if($fs->exists($absolutePath."data/".$fileName.".run")){
            unlink($absolutePath."data/".$fileName.".run");
        }
        if($fs->exists($absolutePath."data/".$fileName.".mod")){
            unlink($absolutePath."data/".$fileName.".mod");
        }

        //procedemos a crear el archivo de datos, si no existe
        if(!$fs->exists($absolutePath."data/".$fileName.".dat")){
            try {
                $fs->touch($absolutePath."data/".$fileName.".PID");
                $fs->touch($absolutePath."data/".$fileName.".dat");
                $fs->touch($absolutePath."data/".$fileName.".run");
                $fs->touch($absolutePath."data/".$fileName.".mod");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating data file ".$e->getPath();
            }
        }

        $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');
       
        //Buscar todos los procesos validados y esta en espera.
        $proceso = $manager->getRepository("AppBundle:Proceso")->find($idproceso);

        //En este punto es donde me doy cuenta que la generación de rutas es solo para una empresa
        if($proceso->getPrcEstado() == 0 && $proceso->getPrcValidado())
        {
            $empresa  = $proceso->getEmpresa();
            $region   = $proceso->getRegion();
            $clientes = $manager->getRepository("AppBundle:Cliente")->obtenerClientesDeLaEmpresa($empresa,$region);
            $camiones = $manager->getRepository("AppBundle:Camion")->buscarCamionesDeLaEmpresa($empresa,true);

            $diarios     =":= ";
            $semanales   =":= ";
            $bisemanales =":= ";
            $trisemanales=":= ";
            $quincenales =":= ";
            $mensuales   =":= ";

            $frecuencia = array(1=>20, 2=>4 , 3=>8 , 4=>12 , 5=>2 , 6=>1);

            $orden = 0;

            foreach($clientes  as $cliente)
            {
                $orden++;
                $procesoCliente = new ProcesoClientes();
                $procesoCliente->setCliente($cliente)->setProceso($proceso)->setPclOrden($orden);
                $manager->persist($procesoCliente);
                $manager->flush();

                if($cliente->getFrecuencia()->getId() == 1)
                    $diarios.= $orden.',';

                if($cliente->getFrecuencia()->getId() == 2)
                    $semanales.= $orden.',';
                
                if($cliente->getFrecuencia()->getId() == 3)
                    $bisemanales.= $orden.',';

                if($cliente->getFrecuencia()->getId() == 4)
                    $trisemanales.= $orden.',';
                
                if($cliente->getFrecuencia()->getId() == 5)
                    $quincenales.= $orden.',';
                
                if($cliente->getFrecuencia()->getId() == 6)
                    $mensuales.= $orden.',';
            }

            $orden = 0;
            foreach($camiones as $camion){
                $orden++;
                $procesoCamiones = new ProcesoCamiones();
                $procesoCamiones->setCamion($camion)->setProceso($proceso)->setPcmOrden($orden);
                $manager->persist($procesoCamiones);
                $manager->flush();
            }


            $diarios     = ($diarios     == ":= ")?"":trim($diarios,',');
            $semanales   = ($semanales   == ":= ")?"":trim($semanales,',');
            $bisemanales = ($bisemanales == ":= ")?"":trim($bisemanales,',');
            $trisemanales= ($trisemanales== ":= ")?"":trim($trisemanales,',');
            $quincenales = ($quincenales == ":= ")?"":trim($quincenales,',');
            $mensuales   = ($mensuales   == ":= ")?"":trim($mensuales,',');


            $configAmpl = $manager
                          ->getRepository("AppBundle:ConfiguracionAmpl")
                          ->findBy(
                            [
                                'empresa'=>$proceso->getEmpresa()->getId()
                            ]);

            $data =  $this->getContainer()->get('twig')
                     ->render('AdminBundle:Data:data.html.twig',
                         [
                            "dias"=> $configAmpl[0]->getDias(),
                            "vehiculos" =>count($camiones),
                            "infinito"=>$configAmpl[0]->getInfinito(),
                            "epsilon"=>$configAmpl[0]->getEpsilon(),
                            "epsilonDos"=>$configAmpl[0]->getEpsilonDos(),
                            "clieDiarios"=>$diarios,
                            "clieSemanales"=>$semanales,
                            "clieBisemanales"=>$bisemanales,
                            "clieTrisemanales"=>$trisemanales,
                            "clieQuincenales"=>$quincenales,
                            "clieMensuales"=>$mensuales,
                            "capacidad"=>$camiones,
                            "clientes"=>$clientes,
                            "frecuencias"=>$frecuencia
                         ]
                     );


            //abrimos el archivo para agregar los contenidos
            file_put_contents($absolutePath."data/".$fileName.".dat", $data);

            $text_file_data = $this->getContainer()->get('twig')->render('AdminBundle:Data:execute.html.twig', [
                "file_data"=>$absolutePath."data/".$fileName.".dat",
                "file_mod"=>$absolutePath."data/".$fileName.".mod",
                "solver"=>$configAmpl[0]->getSolver()
            ]);

            //abrimos el archivo para agregar los contenidos
            file_put_contents($absolutePath."data/".$fileName.".run", $text_file_data);
            
            $text_file_mod = $this->getContainer()->get('twig')->render('AdminBundle:Data:model.html.twig', [
                "file_data"=>$fileName.".dat",
            ]);

            //abrimos el archivo para agregar los contenidos
            file_put_contents($absolutePath."data/".$fileName.".mod", $text_file_mod);

            $proceso->setPrcEstado(1)->setPrcObservacion("Generando rutas de trabajo...");
            $manager->persist($proceso);
            $manager->flush();
            
            $output->writeln("La carga de rutas de trabajo ha comenzado. Este proceso puede tardar.", FILE_APPEND);

            //llamar a ampl
            $process = new Process('ampl '.$absolutePath."data/".$fileName.".run > ".$absolutePath."data/".$fileName.".sol");
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

        }else{
            $output->writeln("No existe proceso con estado \"En espera\" y validado.", FILE_APPEND);
        }
    }
}