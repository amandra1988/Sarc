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
    protected static $defaultName = 'sarc:terminate-process';
    public function __construct()
    {
    
        // you *must* call the parent constructor
        parent::__construct();
    }
    protected function configure()
    {
        $this->setName('sarc:terminate-process')
             ->setDescription('Removes .PID file to terminate a process')
             ->setHelp('This command deletes a .PID file to terminate a process and changes the state in the database.')
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

        //Eliminar archivo .PID
        if($fs->exists($absolutePath."data/".$nfile.".PID")){
            unlink($absolutePath."data/".$nfile.".PID");
        }

        $manager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $proceso = $manager->getRepository("AppBundle:Proceso")->find($idProceso);

        $proceso->setPrcEstado(3)
                ->setPrcTermino(new \DateTime(date('Y-m-d H:s:i')))
                ->setPrcObservacion('Proceso finalizado correctamente.');
            
        $manager->persist($proceso);
        $manager->flush();
        
        $output->writeln("Proceso finalizado", FILE_APPEND);

        $fs->touch($absolutePath."data/".$nfile.".end");

    }
}