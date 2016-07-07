<?php

namespace ClientBundle\Form;

use ClientBundle\Form\Embeddable\ContactsForm;
use ClientBundle\Form\Embeddable\AddressForm;
use ClientBundle\Utils\UserUtils;
use ClientBundle\Form\Type\UsersType;
use ClientBundle\Form\Type\UserHiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CustomerForm
 * @package ClientBundle\Form
 */
class CustomerForm extends AbstractType
{
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $user = $this->getUser();

        $builder
            ->add('company')
            ->add('address', AddressForm::class)
            ->add('contacts', ContactsForm::class)
            ->add('info')
            ->add('save', SubmitType::class);

        if ($user && $user->hasRole('ROLE_ADMIN')) {
            $builder->add('user', UsersType::class);
        } else {
            $builder->add('user', UserHiddenType::class);
        }
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

    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}