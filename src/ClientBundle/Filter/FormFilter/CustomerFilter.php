<?php

namespace ClientBundle\Filter\FormFilter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CustomerFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company', Filters\TextFilterType::class, array(
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
        ));
        $builder->add('address', AddressFilterType::class);
    }

    public function getBlockPrefix()
    {
        return 'customer_filter';
    }
//
//    public function getName()
//    {
//        return $this->getBlockPrefix();
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}