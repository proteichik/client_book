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
        $type = $input->getArgument('type');

        $logger = $this->getContainer()->get('statistic.logger.console_logger');
        $logger->info(sprintf('Start command [%s] with type [%s]', $this->options['name'], $type));

        $factory = $this->getFactory();
        $reader = $factory->getReader($type);
        $processor = $factory->getProcessor();
        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $workflow = new Workflow($reader, $processor, $dispatcher);
        $workflow->process();
        $logger->info(sprintf('Finish command [%s] with type [%s]', $this->options['name'], $type));
        $logger->info('***');
    }
}