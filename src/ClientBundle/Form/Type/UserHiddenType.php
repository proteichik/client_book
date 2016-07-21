<?php

namespace ClientBundle\Form\Type;

use ClientBundle\Form\AbstractExtendedType;
use ClientBundle\Form\DataTransformer\CurrentUserTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class CustomerHiddenType
 * @package ClientBundle\Form\Type
 */
class UserHiddenType extends AbstractExtendedType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
}