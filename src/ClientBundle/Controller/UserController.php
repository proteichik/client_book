<?php

namespace ClientBundle\Controller;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var string
     */
    protected $formClass;

    /**
     * UserController constructor.
     * @param UserManagerInterface $userManager
     * @param string $formClass
     */
    public function __construct(UserManagerInterface $userManager, $formClass)
    {
        $this->userManager = $userManager;
        $this->setFormClass($formClass);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param string $formClass
     */
    public function setFormClass($formClass)
    {
        if (!is_string($formClass)) {
            throw new \InvalidArgumentException('Form class must be a string');
        }

        $this->formClass = $formClass;
    }

    /**
     * Создание юзера
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $user = $this->userManager->createUser();

        $form = $this->createForm($this->formClass, $user, array(
            'validation_groups' => array('create'),
        ));
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $this->redirectToRoute('client_admin.users');
        }

        return $this->render('users/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Обновление инф. юзера
     *
     * @param Request $request
     * @param $username
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        $form = $this->createForm($this->formClass, $user, array(
            'validation_groups' => array('update'),
        ));

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $this->userManager->updateUser($user);

            return $this->redirectToRoute('client_admin.user.update',
                array('username' => $username));
        }

        return $this->render('users/update.html.twig',
            array('form' => $form->createView(),
                'object' => $user
                ));
    }

}