<?php

namespace Tests\ClientBundle\Form\Embeddable;

use ClientBundle\Form\Embeddable\ContactsForm;
use ClientBundle\Entity\Embeddable\Contacts;
use Tests\ClientBundle\Form\AbstractFormTestCase;

class ContactsFormTest extends AbstractFormTestCase
{
    public function testSubmitValidData()
    {
        $data = array(
            'work' => 'test',
            'mobile' => 'test',
            'fax' => '012345678',
            'email' => '123@tut.by',
        );

        $object = new Contacts();
        $object->setWork($data['work']);
        $object->setMobile($data['mobile']);
        $object->setFax($data['fax']);
        $object->setEmail($data['email']);

        $form = $this->factory->create(ContactsForm::class);

        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}