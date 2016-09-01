<?php

namespace ClientBundle\Form;

use ClientBundle\Form\DataTransformer\ValueToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', Type\TextType::class)
            ->add('email', Type\EmailType::class, array(
                'attr' => array('autocomplete' => 'off')
            ))
            ->add('plainPassword', Type\PasswordType::class)
            ->add('roles', Type\ChoiceType::class, array(
                'choices' => array(
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                ),
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('submit', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\User',
        ));
    }

    public function getBlockPrefix()
    {
        return 'user';
    }
}