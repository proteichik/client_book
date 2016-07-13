<?php

namespace ClientBundle\Controller;

use ClientBundle\Controller\Base\FilteredBaseController;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends FilteredBaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->prepareForm($request, $this->getPrototype(), array(
            'action' => $this->generateUrl('client_customer.add'),
        ));

        if ($this->runSave($form)) {
            return $this->redirectToRoute('client_customers');
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView()));

    }

    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $object = $this->getService()->find($id);

        if (!$object) {
            throw new \InvalidArgumentException('Object not found');
        }

        $form = $this->prepareForm($request, $object, array(
            'action' => $this->generateUrl('client_customer.edit', array('id' => $object->getId()))
        ));

        if ($this->runSave($form)) {
            return $this->redirectToRoute('client_customer.edit', array('id' => $object->getId()));
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'form' => $form->createView(),
            'object' => $object));
    }
}