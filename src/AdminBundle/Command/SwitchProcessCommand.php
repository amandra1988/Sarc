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

       $nameEvent = $input->getArgument('event');
       $fileName= $input->getArgument('file_name');

/*
		? Si es *.dat,  ejecutar saarc-proces-scipampl
			§ Inicia scipampl, crea un archivo *.PID
		? Si es *.PID  ejecutar saarc-update-info-process
		? Si es *.solve ejecutar saarc-create-route

*/
      $str = strpos($fileName, '.');

      if ($str === false) {
         throw new \RuntimeException("El nombre del archivo debe tener el separador '.' ");
      }else{
         $fileExtension = substr($fileName,strrpos($fileName,'.',-1),strlen($fileName));
echo $fileExtension;
         if (empty($fileExtension)) {
            throw new \RuntimeException("El nombre del archivo debe tener una exension");
         }

      }



       if ($nameEvent == "IN_CREATE") {


       }

       if ($nameEvent == "IN_MODIFY") {

       }

       if ($nameEvent == "IN_DELETE") {

       }


       $command = $this->getApplication()->find('saarc:create-data-file');

         $arguments = array(
            'command' => 'saarc:create-data-file'
            //'name'    => 'saarc:create-data-file',
            //'--yell'  => true,
         );

         $greetInput = new ArrayInput($arguments);
         $returnCode = $command->run($greetInput, $output);



    }
}