<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseEventController
 * @package ClientBundle\Controller\Base
 */
class BaseEventController extends FilteredBaseController
{
    /**
     * @param Request $request
     * @param Customer $customer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRecentDoneAction(Request $request, Customer $customer)
    {
        $max = ($this->container->hasParameter('max.recent')) ? $this->getParameter('max.recent') : 5;

        $objects = $this->getService()->findBy(
            array(
                'criteria' => array(
                    'customer' => $customer,
                    'status' => AbstractEvent::DONE_TYPE),
                'order' => array('date' => 'desc'),
                'limit' => $max,
            )
        );

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'objects' => $objects,
            'customer' => $customer));
    }

    /**
     * @param Request $request
     * @param $id_customer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $id_customer)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $customer = $this->get('client.service.customer')->find($id_customer);

        if (!$customer) {
            throw new \InvalidArgumentException('Customer not found');
        }

        $object = $this->getPrototype();
        $object->setCustomer($customer);
        $object->setDate(new \DateTime());

        $form = $this->prepareForm($request, $object);

        if ($this->runSave($form)) {
            return $this->redirectToRoute('client_customer.edit', array('id' => $id_customer));
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'form' => $form->createView(),
            'customer' => $customer));
    }
}