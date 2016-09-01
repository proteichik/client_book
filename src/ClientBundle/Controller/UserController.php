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

    public function createAction(Request $request)
    {
        $user = $this->userManager->createUser();

        $form = $this->createForm($this->formClass, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $this->redirectToRoute('client_admin.users');
        }

        return $this->render('users/create.html.twig', array('form' => $form->createView()));
    }

}