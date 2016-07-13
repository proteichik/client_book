<?php

namespace ClientBundle\Controller;

use ClientBundle\Controller\Base\FilteredBaseController;
use ClientBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;

class CallController extends FilteredBaseController
{
    public function showFormAction(Request $request, Customer $customer)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $object = $this->getPrototype();
        $object->setCustomer($customer);

        $form = $this->createForm($this->getForm(), $object, array(
            'action' => $this->generateUrl('client_call.add', array(
                'id_customer' => $customer->getId(),
            ))
        ));

        return $this->render('call/form/form.html.twig', array('form' => $form->createView()));
    }

    public function createAction(Request $request, $id_customer)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->prepareForm($request, $this->getPrototype());

        if ($this->runSave($form)) {
            return $this->redirectToRoute('client_customer.edit', array('id' => $id_customer));
        }

        return $this->render('call/form/form.html.twig', array('form' => $form->createView()));
    }
}