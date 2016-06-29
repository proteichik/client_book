<?php

namespace ClientBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('date', null, array('attr' => array('class' => 'form-control')))
            ->add('status', null, array('attr' => array('class' => 'form-control')))
            ->add('info', null, array('attr' => array('class' => 'form-control')))
            ->add('customer', EntityType::class, array(
                'class' => 'ClientBundle:Customer',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.company', 'DESC');
                },
                'attr' => array('class' => 'form-control')
            ));
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