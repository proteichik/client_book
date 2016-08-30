<?php

namespace ClientBundle\Filter\FormFilter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class UsersFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', Filters\TextFilterType::class, array(
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ))
            ->add('email', Filters\TextFilterType::class, array(
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ))
            ->add('locked', Filters\ChoiceFilterType::class, array(
                'choices' => array(
                    'Активный' => 0,
                    'Заблокированный' => 1,
                )
            ))
            ->add('lastLogin', Filters\DateRangeFilterType::class, array(
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
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
        ));
    }

    public function getBlockPrefix()
    {
        return 'users_filter';
    }
}