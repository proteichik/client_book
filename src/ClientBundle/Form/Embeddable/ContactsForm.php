<?php

namespace ClientBundle\Form\Embeddable;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactsForm
 * @package ClientBundle\Form\Embeddable
 */
class ContactsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('work')
            ->add('mobile')
            ->add('fax')
            ->add('email')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Embeddable\Contacts',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contacts';
    }
}