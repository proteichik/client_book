<?php

namespace ClientBundle\Form\Type;

use ClientBundle\Form\DataTransformer\CurrentUserTransformer;
use ClientBundle\Utils\UserUtils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class CustomerHiddenType
 * @package ClientBundle\Form\Type
 */
class UserHiddenType extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CurrentUserTransformer($this->tokenStorage));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /**
     * @return null|\Symfony\Component\Security\Core\User\UserInterface
     */
    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}