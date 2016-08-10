<?php

namespace Statistic\BasicBundle\Command;

use Statistic\BasicBundle\Workflow\Workflow;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractCommand extends ContainerAwareCommand
{
    protected $options = array();

    abstract protected function getFactory();
    abstract protected function configureOptions(OptionsResolver $resolver);

    public function __construct($name = null)
    {
        $resolver = new OptionsResolver();
        $this->setDefaults($resolver);
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve();

        parent::__construct($name);
    }

    protected function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'name',
            'description',
        ));
    }

    protected function configure()
    {
        $this->setName($this->options['name'])
            ->setDescription($this->options['description'])
            ->addArgument('type', InputArgument::REQUIRED, 'Event type')
            ->addOption('test', null, InputOption::VALUE_NONE)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start');
        $type = $input->getArgument('type');

        $factory = $this->getFactory();
        $reader = $factory->getReader($type);
        $processor = $factory->getProcessor();

        $workflow = new Workflow($reader, $processor);
        $workflow->process();
        $output->writeln('Finish');
    }
}