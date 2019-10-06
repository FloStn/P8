<?php

namespace Tests\AppBundle\Handler\Form;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Handler\Form\TaskFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class TaskFormHandlerTest
 * @package Tests\AppBundle\Handler\Form
 */
class TaskFormHandlerTest extends TestCase
{
    /**
     * @var TaskFormHandler
     */
    private $taskFormHandler;

    public function setUp()
    {
        $this->taskFormHandler = new TaskFormHandler(
            $this->createMock(EntityManagerInterface::class)
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

        $this->assertEquals(
            $good,
            $this->taskFormHandler->createFormHandler(
                $this->createMock(User::class),
                $this->createMock(Task::class),
                $form
            )
            );
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

        $this->assertEquals(
            $good,
            $this->taskFormHandler->editFormHandler($form)
        );
    }
}