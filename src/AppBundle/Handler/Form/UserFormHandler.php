<?php

namespace AppBundle\Handler\Form;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserFormHandler
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
     * @param FormInterface $form
     *
     * @return boolean
     */
    public function createFormHandler(User $user, FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Manage submit edit form
     *
     * @param User          $user
     * @param FormInterface $form
     *
     * @return boolean
     */
    public function editFormHandler(User $user, FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
