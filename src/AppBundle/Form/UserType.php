<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer();
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez saisir un nom d'utilisateur."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 30,
                        'minMessage' => "Le nom d'utilisateur doit être composé de {{ limit }} caractères minimum.",
                        'maxMessage' => "Le nom d'utilisateur doit être composé de {{ limit }} caractères maximum.",
                    ]),
                ],
            ])
            ->add(
                'password',
                RepeatedType::class,
                [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
                ]
            )
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez saisir une adresse email."
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 60,
                        'minMessage' => "L'email doit être composé de {{ limit }} caractères minimum.",
                        'maxMessage' => "L'email' doit être composé de {{ limit }} caractères maximum.",
                    ]),
                ],
            ])
            ->add(
                $builder->create(
                    'roles',
                    ChoiceType::class,
                    [
                        'label' => 'Rôle',
                        'multiple' => false,
                        'choices' => [
                            'Rôle Utilisateur' => 'ROLE_USER',
                            'Rôle Administrateur' => 'ROLE_ADMIN',
                        ],
                        'constraints' => [
                            new NotBlank([
                                'message' => "Vous devez définir un rôle."
                            ])
                        ],
                    ]
                )->addModelTransformer($transformer)
            );
        ;
    }
}
