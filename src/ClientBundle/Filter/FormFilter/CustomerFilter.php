<?php

namespace ClientBundle\Filter\FormFilter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class CustomerFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company', Filters\TextFilterType::class, array(
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
        ));
    }

    public function getBlockPrefix()
    {
        return 'customer_filter';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}