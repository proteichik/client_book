<?php

namespace ClientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $objects = $this->getService()->findAll();
        } else {
            $options = array(
                'criteria' => array(
                    'user' => $this->getUser(),
                ),
            );
            $objects = $this->getService()->findBy($options);
        }


        return $this->render($this->getTemplateName($this, __METHOD__), array('objects' => $objects));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm($this->getForm(), $this->getPrototype());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setUser($this->getUser());

            $this->getService()->save($form->getData());
            return $this->redirectToRoute('client_customers');
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView()));
    }
}