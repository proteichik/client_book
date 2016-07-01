<?php
namespace Juglon\AdminBundle\Controller;

use Juglon\AdminBundle\Model\AbstractEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $objects = $this->getService()->findAll();

        return $this->render($this->getTemplateName($this, __METHOD__), array('objects' => $objects));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($id)
    {
        $object = $this->getService()->getObjectDetail($id);

        return $this->render($this->getTemplateName($this, __METHOD__), array('object' => $object));
    }

    /**
     * @param Request $request
     * @param $routeTo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $routeTo)
    {
        $form = $this->createForm($this->getForm(), $this->getPrototype());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getService()->save($form->getData());

            if ($routeTo) {
                return $this->redirectToRoute($routeTo['route']);
            }
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @param $id
     * @param $routeTo
     * @throws \InvalidArgumentException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id, $routeTo)
    {
        $object = $this->getService()->findById($id);

        if (!$object) {
            throw new \InvalidArgumentException('Object not find');
        }

        $form = $this->createForm($this->getForm(), $object);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getService()->save($object);

            if ($routeTo) {
                return $this->redirectToRoute($routeTo['route']);
            }
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView(),
            'object' => $object));

    }

    /**
     * @param Request $request
     * @param $id
     * @param $routeTo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id, $routeTo)
    {
        $object = $this->getService()->findById($id);

        if (!$object) {
            throw new \InvalidArgumentException('Object not find');
        }

        if ($request->getMethod() === "POST"){
            if ($request->get("delete_confirmation", "no") === "yes") {
                $this->getService()->delete($object);
            }

            if ($routeTo) {
                return $this->redirectToRoute($routeTo['route']);
            }
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('object' => $object));
    }


}