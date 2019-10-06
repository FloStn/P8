<?php

namespace Tests\AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Security\TaskVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoterTest extends TestCase
{
    /**
     * @var TaskVoter
     */
    private $taskVoter;

    public function setUp()
    {
        $this->taskVoter = new class() extends TaskVoter {
            public function supports($attribute, $subject)
            {
                return parent::supports($attribute, $subject);
            }

            public function voteOnAttribute($attribute, $subject, TokenInterface $token)
            {
                return parent::voteOnAttribute($attribute, $subject, $token);
            }
        };
    }

    /**
     * @dataProvider provideSupportsData
     *
     * @param string $attribute
     * @param boolean $supports
     */
    public function testSupports(string $attribute, object $subject, bool $supports)
    {
        $this->assertEquals(
            $supports,
            $this->taskVoter->supports($attribute, $subject)
        );
    }

    public function provideSupportsData(): \Generator
    {
        yield [TaskVoter::EDIT, new Task(), true];
        yield [TaskVoter::DELETE, new Task(), true];
        yield ["fail", new Task(), false];
        yield [TaskVoter::EDIT, new \stdClass(), false];
    }

    /**
     * @param string $attribute
     * @param boolean $supports
     */
    public function testExceptionOnVote()
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method("getUser")->willReturn(new User());

        $this->expectException(\LogicException::class);
        $this->taskVoter->voteOnAttribute("", new Task(), $token);
    }

    /**
     * @dataProvider provideVoteData
     *
     * @param string $attribute
     * @param boolean $supports
     */
    public function testVote(string $attribute, Task $task, ?User $user, bool $supports)
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method("getUser")->willReturn($user);

        $this->assertEquals(
            $supports,
            $this->taskVoter->voteOnAttribute($attribute, $task, $token)
        );
    }

    public function provideVoteData(): \Generator
    {
        //yield [TaskVoter::EDIT, new Task(), true];
        yield ['', new Task(), null, false];

        yield from $this->provideEditData();
        yield from $this->provideDeleteData();
    }

    public function provideDeleteData(): \Generator
    {
        $task = new Task();
        $user = new User();

        $task->setAuthor($user);
        yield [TaskVoter::DELETE, $task, $user, true];

        $task = new Task();
        $user2 = new User();

        $task->setAuthor($user2);
        yield [TaskVoter::DELETE, $task, $user, false];

        $task = new Task();
        $user = new User();
        $user->setRoles(["ROLE_USER"]);

        yield [TaskVoter::DELETE, $task, $user, false];

        $task = new Task();
        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);

        yield [TaskVoter::DELETE, $task, $user, true];
    }

    public function provideEditData(): \Generator
    {
        $task = new Task();
        $user = new User();

        $task->setAuthor($user);
        yield [TaskVoter::EDIT, $task, $user, true];

        $task = new Task();
        $user2 = new User();

        $task->setAuthor($user2);
        yield [TaskVoter::EDIT, $task, $user, false];
    }
}