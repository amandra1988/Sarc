<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\InputArgument;

class UpdateInfoProcessCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sarc:update-info-process';
    public function __construct()
    {
    
        // you *must* call the parent constructor
        parent::__construct();
    }
    protected function configure()
    {
        $this->setName('sarc:update-info-process')
             ->setDescription('Create .PID file to tell you how to find it running a process')
             ->setHelp('This command creates .PID file, this way it indicates that a process is running.')
             ->addArgument('file_name', InputArgument::OPTIONAL, 'You need pass name of file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');

        if(!$fs->exists($absolutePath."data")){
            try {
                $fs->mkdir($this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/')."data");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }

        if($fs->exists($absolutePath."data/data.PID")){
            unlink($absolutePath."data/data.PID");
        }

        if(!$fs->exists($absolutePath."data/data.PID")){
            try {
                $fs->touch($absolutePath."data/data.PID");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating data file ".$e->getPath();
            }
        }

        $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        //Buscar todos los procesos validados y esta en espera        
        $proceso = $manager->getRepository("AppBundle:Proceso")->procesoEnEsperaDeEjecucion(1,0);

        if(count($proceso)>0){

            $proceso[0]->setPrcEstado(1)->setPrcObservacion('Generando planificación de rutas de trabajo...');  
            $manager->persist($proceso[0]);
            $manager->flush();
            $output->writeln("Archivo creado correctamente", FILE_APPEND);

        }else{
            $output->writeln("Nada que actualizar", FILE_APPEND);
        }
    }
}