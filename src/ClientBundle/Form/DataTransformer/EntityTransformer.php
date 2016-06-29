<?php
namespace ClientBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EntityTransformer
 * @package ClientBundle\Form\DataTransformer
 */
class EntityTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $repositoryClass;

    /**
     * @param ObjectManager $manager
     * @param $repositoryClass
     */
    public function __construct(ObjectManager $manager, $repositoryClass)
    {
        $this->manager = $manager;
        $this->setRepositoryClass($repositoryClass);
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param ObjectManager $manager
     */
    public function setManager(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    public function getRepositoryClass()
    {
        return $this->repositoryClass;
    }

    /**
     * @param string $repositoryClass
     */
    public function setRepositoryClass($repositoryClass)
    {
        if (!is_string($repositoryClass)) {
            throw new \InvalidArgumentException('Repository class must be a string!');
        }

        $this->repositoryClass = $repositoryClass;
    }

    /**
     * @param mixed $entity
     * @return int
     */
    public function transform($entity)
    {
        if (!$entity){
            return null;
        }

        return $entity->getId();
    }

    /**
     * @param int $id
     * @return object
     */
    public function reverseTransform($id)
    {
        $object = $this->manager->getRepository($this->repositoryClass)->find($id);

        if (!$object) {
            throw new TransformationFailedException('Object id '.$id.' not found');
        }

        return $object;
    }

}