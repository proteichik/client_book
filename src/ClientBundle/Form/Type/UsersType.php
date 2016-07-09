<?php

namespace ClientBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerType
 * @package ClientBundle\Form\Type
 */
class UsersType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'ClientBundle:User',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')->orderBy('u.username', 'DESC');
            },
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return EntityType::class;
    }
}