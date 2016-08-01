<?php

namespace ClientBundle\Filter\FormFilter\Type;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EmbeddedFilterTypeInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ClientBundle\Entity\Embeddable\Address;

class AddressFilterType extends AbstractType implements  EmbeddedFilterTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('unp', Filters\NumberFilterType::class, array(
            'condition_operator' => FilterOperands::OPERATOR_EQUAL,
        ));

    }

    public function getBlockPrefix()
    {
        return 'user_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }


}