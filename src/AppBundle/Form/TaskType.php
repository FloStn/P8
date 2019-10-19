<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez saisir un titre."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => "Le titre doit être composé de {{ limit }} caractères minimum.",
                        'maxMessage' => "Le titre doit être composé de {{ limit }} caractères maximum.",
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez saisir du contenu."
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 200,
                        'minMessage' => "Le contenu doit être composé de {{ limit }} caractères minimum.",
                        'maxMessage' => "Le contenu doit être composé de {{ limit }} caractères maximum.",
                    ]),
                ],
            ])
            //->add('author') ===> must be the user authenticated
        ;
    }
}
