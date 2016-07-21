<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $object->setUser($customer->getUser());
        $object->setDate(new \DateTime());

        $form = $this->prepareForm($request, $object, array(
            'validation_groups' => array('Default', 'creation'),
        ));

        if ($this->runSave($form)) {
            return $this->redirectToRoute('client_customer.edit', array('id' => $id_customer));
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'form' => $form->createView(),
            'customer' => $customer));
    }

    public function activateStatusAction(Request $request, $id_customer, $id_event)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$request->isXmlHttpRequest()) {
            throw new \RuntimeException('Not Ajax request');
        }

        $event = $this->getService()->find($id_event);

        if (!$event) {
            throw $this->createNotFoundException('Event not found');
        }

        //TO-DO!!! Добавить проверку прав на установку статуса

        $event->setStatus(AbstractEvent::DONE_TYPE);
        $validator = $this->get('validator');
        if (count($validator->validate($event, null, array('Default', 'activate'))) === 0) {
            $this->getService()->save($event);
        }

        return new Response(json_encode($event), 200);
    }
}