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
use Symfony\Component\Console\Output\BufferedOutput;

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
        //validadamos que no se ha realizado el proceso.
        $fs = new Filesystem();

        $this->_execute = $this->getContainer();
        
        //argregamos al log todos los parametros
        $logger = $this->getContainer()->get('logger');
        $nameEvent = ltrim($input->getArgument('event'), '"');

        $fileName = str_replace('"','',$input->getArgument('file_name'));
        $archivo = explode(".", $fileName);
        $file = $archivo[0];


        //obtenemos la ruta del modulo AdminBundle
        $absolutePath =$this->getContainer()->get('kernel')->locateResource('@AdminBundle/Resources/');
        //siempre borramos el archivo, temas cache
        if($fs->exists($absolutePath."data/".$file.".end")){
            $logger->info('SARC: ERROR proceso ya realizado');
            throw new \RuntimeException("Proceso ya realizado");
        }
  
        $a = substr($fileName,strrpos($fileName,'.',-1),strlen($fileName));
        $fileExtension = str_replace('"','',$a);
        
        if($fs->exists($absolutePath."data/".$file.".PID")){
            
            $logger->info($nameEvent .$fileName. $fileExtension);

            if($fileExtension == ".sol"  && $nameEvent == "IN_CREATE"){

                $logger->info('SARC sol');
                $this->_execute = $this->getContainer()->get("createroute.command");

                $this->_arguments = array(
                    'file_name' => $fileName
                );
                //obtnemos los parametros del comando
                $greetInput = new ArrayInput($this->_arguments);
                //ejecutamos el comando
                $output = new BufferedOutput();

                $this->_execute ->run($greetInput , $output);
                $content = $output->fetch();
                $logger->info('SARC eee' .$content);
            }

            if ($fileExtension == ".PID" && $nameEvent == "IN_MODIFY"){
                $this->_execute = $this->getContainer()->get("updateinfoprocess.command");
                $logger->info('SARC IN_MODIFY: '. $nameEvent . " " . $fileName);

                $this->_arguments = array(
                    'file_name' => $fileName
                );
                //obtnemos los parametros del comando
                $greetInput = new ArrayInput($this->_arguments);
                //ejecutamos el comando
                $this->_execute->run($greetInput , $output);
            }
        }
    }
}