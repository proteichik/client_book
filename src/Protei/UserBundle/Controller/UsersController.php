<?php

namespace Protei\UserBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Protei\UserBundle\Service\UsersServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersController extends Controller
{
    /**
     * @var UsersServiceInterface
     */
    protected $usersService;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @var string
     */
    protected $filterClass;

    /**
     * UsersController constructor.
     * @param UsersServiceInterface $usersService
     * @param $filterClass
     * @param PaginatorInterface $paginator
     */
    public function __construct(UsersServiceInterface $usersService, $filterClass, PaginatorInterface $paginator)
    {
        $this->usersService = $usersService;
        $this->paginator = $paginator;
        $this->setFilterClass($filterClass);
    }

        
    /**
     * @param PaginatorInterface $paginator
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param string $filterClass
     */
    public function setFilterClass($filterClass)
    {
        if (!is_string($filterClass)) {
            throw new \InvalidArgumentException('Filter class must be a string');
        }

        $this->filterClass = $filterClass;
    }

    /**
     * Список всех юзеров (с фильтрацией)
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->usersService->findAllUsers(array(), false);

        $filterForm = $this->createForm($this->filterClass);
        if ($request->query->has($filterForm->getName())) {
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $qb);
        }

        $items = $this->paginate(
            $qb, 
            $request->query->getInt('page', 1)
        );
        

        return $this->render('users/list.html.twig', array('objects' => $items, 'filter' => $filterForm->createView()));
    }

    /**
     * Пагинация
     *
     * @param $query
     * @param $page
     * @param int $itemPerPage
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    protected function paginate($query, $page, $itemPerPage = 0)
    {
        if (0 === $itemPerPage) {
            $itemPerPage = ($this->container->hasParameter('users_per_page')) ? $this->getParameter('users_per_page') : 10;
        }

        return $this->paginator->paginate(
            $query,
            $page,
            $itemPerPage
        );
    }
}