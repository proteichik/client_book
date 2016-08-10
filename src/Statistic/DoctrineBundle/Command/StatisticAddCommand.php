<?php

namespace Statistic\DoctrineBundle\Command;

use Statistic\BasicBundle\Command\AbstractCommand;
use Statistic\DoctrineBundle\Factory\StatisticAddFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatisticAddCommand extends AbstractCommand
{
    protected function getFactory()
    {
        return $this->getContainer()->get('statistic.doctrine.factory.add_factory');
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'statistic:doctrine:add',
            'description' => 'Command for generate statistic (Doctrine)',
        ));
    }

}