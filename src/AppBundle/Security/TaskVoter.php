<?php

namespace AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Task) {
            
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($task, $user);
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Task $task, User $user)
    {
        if ($this->canEdit($task, $user)) {
            return true;
        }

        return !$task->isPrivate();
    }

    private function canEdit(Task $task, User $user)
    {
        return $user === $task->getOwner();
    }

    private function canDelete(Task $task, User $user)
    {
        $taskAuthor = $task->getAuthor();
        
        if ($taskAuthor === null) {
            foreach ($user->getRoles() as $role) {
                if ($role == "ROLE_ADMIN") {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return $taskAuthor === $user;
    }
}
