<?php

namespace ClientBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use ClientBundle\Form\DataTransformer\EntityTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EntityHiddenType
 * @package Juglon\AdminBundle\Form\Type
 */
class EntityHiddenType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('class'))->setDefaults(array('invalid_message' => 'The entity does not exist.'));
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityTransformer($this->manager, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'entity_hidden';
    }

}