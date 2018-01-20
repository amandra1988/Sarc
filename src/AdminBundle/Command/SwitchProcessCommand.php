<?php

namespace AdminBundle\Command;
use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
/*
1) bin/console sarc:switch-process IN_CREATE .dat     -- Crear el archvio .dat a partir de un proceso validado y con estado 0
2) bin/console sarc:switch-process IN_CREATE .PID     -- Crear el archvio .PID actualiza el estado del proceso a 1 "En proceso"
3) bin/console sarc:switch-process IN_CREATE .sol     -- Crear el archvio .PID carga las rutas de trabajo del archivo devuelto por ampl
*/
class SwitchProcessCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sarc:switch-process';
    protected $_execute;
    protected $_arguments;
    public function __construct()
    {
    
        // you *must* call the parent constructor
        parent::__construct();
    }
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

        $this->command = $this->getContainer();
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
            '.dat'=>"createdatafile.command", //solo debe ser a traves de cron
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
            $this->_execute = $this->getContainer()->get('create.command');
            $this->_arguments = array(
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_MODIFY"){
            $this->_execute = $this->getContainer()->get('sarc:update-info-process');
            $this->_arguments = array(
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_DELETE"){
            $this->_execute = $this->getContainer()->get('sarc:terminate-process');
            $this->_arguments = array(
                'file_name' => $fileExtension
            );
            $logger->info('SARC: '. $nameEvent . " " . $fileName);
        }

        //obtnemos los parametros del comando
        $greetInput = new ArrayInput($this->_arguments);
        //ejecutamos el comando
        $this->_execute->run($greetInput , $output);
    }
}