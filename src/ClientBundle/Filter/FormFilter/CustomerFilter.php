<?php

namespace ClientBundle\Filter\FormFilter;

use ClientBundle\Utils\UserUtils;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomerFilter extends AbstractType
{
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company', Filters\TextFilterType::class, array(
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
        ));
        $builder->add('address', AddressFilterType::class);

        $user = $this->getUser();
        if ($user && $user->hasRole('ROLE_ADMIN')) {
            $builder->add('user', Filters\EntityFilterType::class, array(
                'class' => 'ClientBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.username', 'DESC');
                },
            ));
        }
    }

    public function getBlockPrefix()
    {
        return 'user_filter';
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
        ));
    }

    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}