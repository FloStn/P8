<?php

namespace AppBundle\Handler\Form;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskFormHandler
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Manage submit create form
     *
     * @param User          $user
     * @param Task          $task
     * @param FormInterface $form
     *
     * @return boolean
     */
    public function createFormHandler(User $user, Task $task, FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($user);

            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Manage submit edit form
     *
     * @param Task          $task
     * @param FormInterface $form
     *
     * @return boolean
     */
    public function editFormHandler(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
