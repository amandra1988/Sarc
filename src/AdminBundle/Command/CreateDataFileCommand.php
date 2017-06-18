<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class CreateDataFileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('saarc:create-data-file')

        // the short description shown while running "php bin/console list"
        ->setDescription('Creates data file for procesing client routes.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows create a data file to procesing cliente route')
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        //obtenemos la ruta del modulo AdminBundle
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');
        //validamos que exista la carpeta data
        if(!$fs->exists($absolutePath."data")){
            // si no exxite la procedemos a crear
            try {
                $fs->mkdir($this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/')."data");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }

        //siempre borramos el archivo, temas cache
        if($fs->exists($absolutePath."data/data.dat")){
            unlink($absolutePath."data/data.dat");
        }

        //procedemos a crear el archivo de datos, si no existe
        if(!$fs->exists($absolutePath."data/data.dat")){
            try {
                $fs->touch($absolutePath."data/data.dat");
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating data file ".$e->getPath();
            }
        }

        //lista de camiones
        $listCamiones = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository("AppBundle:Camion")->infoCamiones();


        $text = $this->getContainer()->get('twig')->render('AdminBundle:Data:data.html.twig', [
                        "dias"=>21,
                        "vehiculos" =>2,
                        "infinito"=>360,
                        "epsilon"=>20,
                        "epsilonDos"=>7,
                        "capacidad"=>$listCamiones
                ]);

        //abrimos el archivo para agregar los contenidos
        file_put_contents($absolutePath."data/data.dat", $text);

        $output->writeln("Archivo creado correctamente", FILE_APPEND);

    }
}