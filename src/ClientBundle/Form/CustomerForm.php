<?php

namespace ClientBundle\Form;

use ClientBundle\Form\Embeddable\ContactsForm;
use ClientBundle\Form\Embeddable\AddressForm;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerForm
 * @package ClientBundle\Form
 */
class CustomerForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('company')
            ->add('address', AddressForm::class)
            ->add('contacts', ContactsForm::class)
            ->add('info')
            ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Customer',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'customer';
    }
}