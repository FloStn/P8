<?php

namespace Tests\AppBundle\Handler\Form;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Handler\Form\UserFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFormHandlerTest
 * @package Tests\AppBundle\Handler\Form
 */
class UserFormHandlerTest extends TestCase
{
    /**
     * @var UserFormHandler
     */
    private $userFormHandler;

    public function setUp()
    {
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method("encodePassword")->willReturn("password");
        $this->userFormHandler = new UserFormHandler(
            $this->createMock(EntityManagerInterface::class),
            $userPasswordEncoder
        );
    }

    /**
     * @return \Generator
     */
    public function provideData(): \Generator
    {
        yield [false, false];
        yield [true, true];
    }

    /**
     * @dataProvider provideData
     *
     * @param boolean $isSubmittedAndValid
     * @param boolean $good
     */
    public function testCreateFormHandler(bool $isSubmittedAndValid, bool $good)
    {
        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn($isSubmittedAndValid);
        $form->method("isValid")->willReturn($isSubmittedAndValid);

        $user = new User();

        $this->assertEquals(
            $good,
            $this->userFormHandler->createFormHandler(
                $user,
                $form
            )
        );

            if ($good) {
                $this->assertEquals("password", $user->getPassword());
            }
    }

    /**
     * @dataProvider provideData
     *
     * @param boolean $isSubmittedAndValid
     * @param boolean $good
     * @return void
     */
    public function testEditFormHandler(bool $isSubmittedAndValid, bool $good)
    {
        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn($isSubmittedAndValid);
        $form->method("isValid")->willReturn($isSubmittedAndValid);

        $user = new User();

        $this->assertEquals(
            $good,
            $this->userFormHandler->editFormHandler(
                $user,
                $form
            )
        );

        if ($good) {
            $this->assertEquals("password", $user->getPassword());
        }
    }
}