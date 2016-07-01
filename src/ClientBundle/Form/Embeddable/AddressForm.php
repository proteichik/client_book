<?php

namespace ClientBundle\Form\Embeddable;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddressForm
 * @package ClientBundle\Form\Embeddable
 */
class AddressForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('city')
            ->add('street')
            ->add('unp')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Embeddable\Address',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'address';
    }
}