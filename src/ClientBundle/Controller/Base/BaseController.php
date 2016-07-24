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
        $query = $this->getService()->findAll();

        $objects = $this->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/
        );

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'objects' => $objects,
            ));
    }

    public function deleteAction(Request $request)
    {

    }
}