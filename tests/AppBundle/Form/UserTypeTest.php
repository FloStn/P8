<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\User;
use AppBundle\Form\Type\TestedType;
use AppBundle\Form\UserType;
use AppBundle\Model\TestObject;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTypeTest extends WebTestCase
{
   private $factory;

   public function setUp()
   {
       $client = static::bootKernel();
       $this->factory = $client->getContainer()->get("form.factory");
   }

    public function testSubmitValidData()
    {
        $formData = [
            'username' => 'username',
            'password' => ['first' => 'password', 'second' => 'password'],
            'email' => 'email',
            'roles' => ["ROLE_USER"]
        ];

        $objectToCompare = new User();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserType::class, $objectToCompare);

        $object = new User();
        $object->setRoles(["ROLE_USER"]);
        $object->setUsername('username');
        $object->setPassword('password');
        $object->setEmail('email');
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}