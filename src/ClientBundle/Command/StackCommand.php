<?php

namespace ClientBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class StackCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('client:stack:run');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            $cmd = $this->getApplication()->find($command['command']);

            $cmdInput = new ArrayInput($command);
            $cmd->run($cmdInput, $output);
        }
    }


    protected function getCommands()
    {
        $path = $this->getContainer()->getParameter('kernel.root_dir') . '/config/command_stack.yml';

        $data = Yaml::parse($this->getFileContent($path));

        return $data['commands'];
    }

    protected function getFileContent($path)
    {
        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('File %s not found', $path));
        }

        return file_get_contents($path);
    }

}