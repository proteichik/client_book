<?php

namespace ClientBundle\Filter\FormFilter;

use ClientBundle\Filter\FormFilter\Type\CustomerFilterType;
use ClientBundle\Utils\UserUtils;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class TodayFilter extends AbstractType
{
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('customer', Filters\EntityFilterType::class, array(
            'class' => 'ClientBundle:Customer',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')->orderBy('c.company', 'DESC');
            },
        ));
    }

    public function getBlockPrefix()
    {
        return 'today_filter';
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