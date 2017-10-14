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

class SwitchProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('sarc:switch-process')//Nombre del comando (La parte despues de "bin/console")
        ->setDescription('Switch between diferent process of SARC.')// the short description shown while running "php bin/console list"
        ->setHelp('This command allows switching between diferent process')// the full command description shown when running the command with. The "--help" option
        ->addArgument('event', InputArgument::REQUIRED, 'You need pass name of events')
        ->addArgument('file_name', InputArgument::REQUIRED, 'You need pass name of file');
    }
  
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //argregamos al log todos los parametros
        $logger = $this->getContainer()->get('logger');
        $nameEvent = $input->getArgument('event');
        $fileName = $input->getArgument('file_name');
       
        $typeEvent = array("IN_CREATE","IN_MODIFY","IN_DELETE");//validamos el primer paramétro

        if (!in_array($nameEvent, $typeEvent)) {
            $logger->info('SARC: ERROR No existe el evento indicado'.$nameEvent." ".$fileName);
            throw new \RuntimeException("No existe el evento indicado ");
        }

        $typeExtension= array(
            '.dat'=>"sarc:create-data-file", //solo debe ser a traves de cron
            '.sol'=>"sarc:create-route",
            '.PID'=>"sarc:update-info-process"
        );
        
        //validamos el segundo parámetro
        $str = strpos($fileName, '.');
        //obtenemos la extensión del archivo, donde el limite es el punto en el nombre
        $fileExtension = substr($fileName,strrpos($fileName,'.',-1),strlen($fileName));

        if ($str === false) {
            $logger->info('SARC: ERROR El segundo parametro (nombre del archivo), debe tener el separador' . $nameEvent . " " . $fileName);
            throw new \RuntimeException("El segundo parametro (nombre del archivo), debe tener el separador '.' ");
        }else{
            //Debe existir en el array $typeExtension
            if (!array_key_exists($fileExtension, $typeExtension)) {
                $logger->info('SARC: ERROR El segundo parametro (nombre del archivo), no tiene una extension conocida ' . $nameEvent . " " . $fileName);
                throw new \RuntimeException("El segundo parametro (nombre del archivo), no tiene una extension conocida");
            }
        }

       if ($nameEvent == "IN_CREATE"){
            $command = $this->getApplication()->find($typeExtension[$fileExtension]);
            $arguments = array(
                'command'   => $typeExtension[$fileExtension],
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_MODIFY"){
            $command = $this->getApplication()->find('sarc:update-info-process');
            $arguments = array(
                'command'   => 'sarc-update-info-process',
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_DELETE"){
            $command = $this->getApplication()->find('sarc:terminate-process');
            $arguments = array(
                'command'   => 'sarc:terminate-process',
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
        }

        //obtnemos los parametros del comando
        $greetInput = new ArrayInput($arguments);
        //ejecutamos el comando
        $returnCode = $command->run($greetInput, $output);
    }
}