<?php

namespace ClientBundle\Form;

use ClientBundle\Form\Type\EntityHiddenType;
use ClientBundle\Form\Type\MyDateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MeetingForm
 * @package ClientBundle\Form
 */
class MeetingForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('date', MyDateTimeType::class)
            ->add('status', CheckboxType::class, array(
                'required' => false,
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
            'data_class' => 'ClientBundle\Entity\Meeting'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'meeting';
    }
}