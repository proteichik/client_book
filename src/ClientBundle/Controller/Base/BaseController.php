<?php
namespace ClientBundle\Controller\Base;

use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $objects = $this->getService()->findAll();

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'objects' => $objects,
            ));
    }
}