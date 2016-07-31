<?php

namespace ClientBundle\Service;

use ClientBundle\Repository\FilterRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\Form\FormInterface;

class FilterService extends BaseService
{
    /**
     * @var FilterBuilderUpdaterInterface
     */
    protected $filterBuilderUpdater;

    /**
     * @param EntityManagerInterface $em
     * @param $repositoryName
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     */
    public function __construct(EntityManagerInterface $em, $repositoryName,
                                FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        parent::__construct($em, $repositoryName);

        $this->filterBuilderUpdater = $filterBuilderUpdater;
    }

    /**
     * @return FilterBuilderUpdaterInterface
     */
    public function getFilterBuilderUpdater()
    {
        return $this->filterBuilderUpdater;
    }

    /**
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     */
    public function setFilterBuilderUpdater(FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        $this->filterBuilderUpdater = $filterBuilderUpdater;
    }

    /**
     * @param FormInterface $filterForm
     * @return mixed
     */
    public function getFilteredList(FormInterface $filterForm)
    {
        $repository = $this->getRepository();
        if (!$repository instanceof FilterRepositoryInterface) {
            throw new \InvalidArgumentException('Filter repository must implements FilteredRepositoryInterface');
        }

        /* @var \Doctrine\ORM\QueryBuilder */
        $filterBuilder = $repository->getFilteredBuilder();

        return $this->getFilteredQuery($filterForm, $filterBuilder);
    }

    public function getFilteredQuery(FormInterface $form, $filterBuilder)
    {
        $this->filterBuilderUpdater->addFilterConditions($form, $filterBuilder);


        return $filterBuilder->getQuery();
    }
}