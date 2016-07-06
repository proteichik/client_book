<?php

namespace Tests\ClientBundle\Form\Embeddable;

use ClientBundle\Entity\Embeddable\Address;
use ClientBundle\Form\Embeddable\AddressForm;
use Tests\ClientBundle\Form\AbstractFormTestCase;

class AddressFormTest extends AbstractFormTestCase
{
    public function testSubmitValidData()
    {
        $data = array(
            'city' => 'test',
            'street' => 'test',
            'unp' => '012345678'
        );

        $object = new Address();
        $object->setCity($data['city']);
        $object->setStreet($data['street']);
        $object->setUnp($data['unp']);

        $form = $this->factory->create(AddressForm::class);

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