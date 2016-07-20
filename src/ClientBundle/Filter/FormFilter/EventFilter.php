<?php

namespace ClientBundle\Filter\FormFilter;

use ClientBundle\Entity\AbstractEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;

/**
 * Class EventFilter
 * @package ClientBundle\Filter\FormFilter
 */
class EventFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateRangeFilterType::class, array(
           'left_date_options' => array(
               'widget' => 'single_text',
               'html5' => false,
               //'data' => new \DateTime()
           ),
            'right_date_options' => array(
                'widget' => 'single_text',
                'html5' => false,
                //'data' => new \DateTime()
            ),
        ));

        $builder->add('status', ChoiceFilterType::class, array(
            'choices' => array(
                'совершенная' => AbstractEvent::DONE_TYPE,
                'запланированная' => AbstractEvent::PLANNED_TYPE,
            ),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
       return 'event_filter';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering'),
        ));
    }


}