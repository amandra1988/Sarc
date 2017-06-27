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
        // the name of the command (the part after "bin/console")
        ->setName('saarc:switch-process')

        // the short description shown while running "php bin/console list"
        ->setDescription('Switch between diferent process of SAARC.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows switching between diferent process')

        ->addArgument('event', InputArgument::REQUIRED, 'You need pass name of events')
        ->addArgument('file_name', InputArgument::REQUIRED, 'You need pass name of file')


    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //argregamos al log todos los parametros
        $logger = $this->getContainer()->get('logger');
        $nameEvent = $input->getArgument('event');
        $fileName= $input->getArgument('file_name');

        //validamos el primer par�metro
        $typeEvent = array("IN_CREATE","IN_MODIFY","IN_DELETE");

        if (!in_array($nameEvent, $typeEvent)) {
            $logger->info('SAARC: ERROR No existe el evento indicado' . $nameEvent . " " . $fileName);
            throw new \RuntimeException("No existe el evento indicado ");

        }

        $typeExtension= array(
            //'.dat'=>"saarc:create-data-file", solo debe ser a traves de cron
            '.sol'=>"saarc:create-route",
            '.PID'=>"saarc:update-info-process"
        );
        //validamos el segundo par�metro
        $str = strpos($fileName, '.');
        //obtenemos la extensi�n del archivo, donde el limite es el punto en el nombre
        $fileExtension = substr($fileName,strrpos($fileName,'.',-1),strlen($fileName));

        if ($str === false) {
            $logger->info('SAARC: ERROR El segundo parametro (nombre del archivo), debe tener el separador' . $nameEvent . " " . $fileName);
            throw new \RuntimeException("El segundo parametro (nombre del archivo), debe tener el separador '.' ");

        }else{
            //Debe existir en el array $typeExtension
            if (!array_key_exists($fileExtension, $typeExtension)) {
                $logger->info('SAARC: ERROR El segundo parametro (nombre del archivo), no tiene una extension conocida ' . $nameEvent . " " . $fileName);
                throw new \RuntimeException("El segundo parametro (nombre del archivo), no tiene una extension conocida");

            }
        }

       if ($nameEvent == "IN_CREATE") {

            $command = $this->getApplication()->find($typeExtension[$fileExtension]);

            $arguments = array(
                'command'   => $typeExtension[$fileExtension],
                'file_name' => $fileExtension
            );

            $logger->info('SAARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_MODIFY") {

            $command = $this->getApplication()->find('saarc:update-info-process');

            $arguments = array(
                'command'   => 'saarc-update-info-process',
                'file_name' => $fileExtension
            );

            $logger->info('SAARC: '. $nameEvent . " " . $fileName);
       }

       if ($nameEvent == "IN_DELETE") {

            $command = $this->getApplication()->find('saarc:terminate-process');

            $arguments = array(
                'command'   => 'saarc:terminate-process',
                'file_name' => $fileExtension
            );

            $logger->info('SAARC: '. $nameEvent . " " . $fileName);

        }

        //obtnemos los parametros del comando
        $greetInput = new ArrayInput($arguments);
        //ejecutamos el comando
        $returnCode = $command->run($greetInput, $output);



    }
}