<?php

namespace ClientBundle\Filter\FormFilter;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChartsFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateRangeFilterType::class, array(
            'left_date_options' => array(
                'widget' => 'single_text',
                'html5' => false,
                //'data' => new \DateTime('first day of this month'),
            ),
            'right_date_options' => array(
                'widget' => 'single_text',
                'html5' => false,
                //'data' => new \DateTime('last day of this month'),
            ),
        ));
    }

    public function getBlockPrefix()
    {
        return 'charts_pie_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering'),
        ));
    }

}