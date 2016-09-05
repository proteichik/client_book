<?php

namespace ClientBundle\Form;

use ClientBundle\Form\DataTransformer\ValueToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', Type\TextType::class)
            ->add('email', Type\EmailType::class, array(
                'attr' => array('autocomplete' => 'off')
            ))
            ->add('plainPassword', Type\TextType::class, array(
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 6,
                        'groups' => array('create', 'update')
                    )),
                    new Assert\NotBlank(array(
                        'groups' => array('create')
                    )),
                    ),
                'required' => false,
                'attr' => array(
                    'autocomplete' => 'off',
                ),
                )
            )
            ->add('roles', Type\ChoiceType::class, array(
                'choices' => array(
                    'Менеджер' => 'ROLE_USER',
                    'Начальник отдела' => 'ROLE_ADMIN',
                    'Администратор' => 'ROLE_SUPER_ADMIN',
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