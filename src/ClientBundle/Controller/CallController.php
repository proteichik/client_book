<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;

class CallController extends BaseController
{
    public function createAction(Request $request, Customer $customer = null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $object = $this->getPrototype();
        $object->setCustomer($customer);

        $form = $this->prepareForm($request, $object, array(
            'action' => $this->generateUrl('client_call.add', array(
                'id_customer' => $customer->getId(),
            )),
        ));

        $this->runSave($form);

        return $this->render('call/form/form.html.twig', array('form' => $form->createView()));
    }
}