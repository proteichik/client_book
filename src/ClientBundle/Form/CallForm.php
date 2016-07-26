<?php

namespace ClientBundle\Form;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Form\Type\EntityHiddenType;
use ClientBundle\Form\Type\MyDateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CallForm
 * @package ClientBundle\Form
 */
class CallForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', MyDateTimeType::class)
            ->add('status', ChoiceType::class, array(
                'choices'  => array(
                    'Выполненный' => AbstractEvent::DONE_TYPE,
                    'Запланированный' => AbstractEvent::PLANNED_TYPE,
                ),
            ))
            ->add('info', null, array(
                'required' => false,
            ))
            ->add('customer', EntityHiddenType::class, array(
                'class' => 'ClientBundle\Entity\Customer',
            ))
            ->add('save', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Call',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'call';
    }
}