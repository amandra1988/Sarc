<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\InputArgument;

class TerminateProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('sarc:terminate-process')
             ->setDescription('Creates data file for procesing client routes.')
             ->setHelp('This command allows create a data file to procesing cliente route')
             ->addArgument('file_name', InputArgument::OPTIONAL, 'You need pass name of file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');


        //Eliminar archivo .PID
        if($fs->exists($absolutePath."data/data.PID")){
            unlink($absolutePath."data/data.PID");
        }

        $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        //Buscar todos los procesos validados y en proceso 
        $proceso = $manager->getRepository("AppBundle:Proceso")->procesoEnEsperaDeEjecucion(1,1);

        if(count($proceso)>0){

            $proceso[0]->setPrcEstado(3)->setPrcTermino(new \DateTime(date('Y-m-d H:s:i')))->setPrcObservacion('Proceso finalizado correctamente.');  
            $manager->persist($proceso[0]);
            $manager->flush();
            $output->writeln("Proceso finalizado", FILE_APPEND);

        }else{
            $output->writeln("Nada que finalizar", FILE_APPEND);
        }
    }
}