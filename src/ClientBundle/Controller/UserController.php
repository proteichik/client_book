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
     * @param int $user_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $user_id)
    {
        $user = $this->findUserOrThrowException(array('id' => $user_id));

        $form = $this->createForm($this->formClass, $user, array(
            'validation_groups' => array('update'),
        ));

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $this->userManager->updateUser($user);

            $this->addFlash('notice', 'Информация сохранена');

            return $this->redirectToRoute('client_admin.user.update',
                array('user_id' => $user_id));
        } else if (!$form->isValid() && $form->isSubmitted()) {
            $this->addFlash('error', 'Ошибка, введены некоректные данные');
        }

        return $this->render('users/update.html.twig',
            array('form' => $form->createView(),
                'object' => $user
                ));
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $user_id)
    {
        $user = $this->findUserOrThrowException(array('id' => $user_id));

        $this->denyAccessUnlessGranted('canDelete', $user, 'You can\'t delete yourself');
        
        //Если у пользователя есть клиенты - удалять нельзя
        if (count($user->getCustomers()) > 0) {
            throw new \RuntimeException('You can\'t delete user because he have customers');
        }
        
        $this->userManager->deleteUser($user);
        
        if ($request->isXmlHttpRequest()) {
            return $this->json($user);
        } else {
            return $this->redirectToRoute('client_admin.users');
        }
    }

    /**
     * @param array $criteria
     * @return \FOS\UserBundle\Model\UserInterface
     */
    protected function findUserOrThrowException(array $criteria = array())
    {
        $user = $this->userManager->findUserBy($criteria);

        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        return $user;
    }

}