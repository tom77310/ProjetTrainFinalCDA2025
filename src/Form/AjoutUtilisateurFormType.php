<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AjoutUtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('civilite', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Mr' => 'Monsieur',
                    'Mme' => 'Madame',
                    'Mlle' => 'Mademoiselle'
                ],
                'placeholder' => 'Sélectionnez',
                'label' => 'Civilité',
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom de famille*',
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le nom est obligatoire."]),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
                        'message' => "Le nom ne doit contenir que des lettres et au moins 2 caractères."
                    ])
                ],
            ])

            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => 'Prénom*',
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le prénom est obligatoire."]),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
                        'message' => "Le prénom ne doit contenir que des lettres et au moins 2 caractères."
                    ])
                ],
            ])
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'required' => false,
            ])

            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => 'Adresse postale*',
                'constraints' => [
                    new Assert\NotBlank(['message' => "L'adresse est obligatoire."]),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-Z0-9À-ÿ\s,.\-\/]{5,}$/u",
                        'message' => "L'adresse ne doit contenir que lettres, chiffres, espaces et les caractères , . - /, et au moins 5 caractères."
                    ])
                ],
            ])
            ->add('cp', NumberType::class, [
                'label' => 'Code postal',
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^[0-9]{5}$/",
                        'message' => "Le code postal doit contenir exactement 5 chiffres."
                    ])
                ],
                'attr' => [
                    'minlength' => '1', 
                    'maxlength' => '5',
                    'class' => 'Code_Postale',
                    'required' =>'false',
                ],
                'required' => false,
            ])
            
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
                        'message' => "La ville ne doit contenir que des lettres, espaces ou tirets et au moins 2 caractères."
                    ])
                ],

            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email*',
                'constraints' => [
                    new Assert\NotBlank(['message' => "L'email est obligatoire."]),
                    new Assert\Email(['message' => "L'email '{{ value }}' n'est pas valide."])
                ],
            ])
            ->add('login', TextType::class, [
                'label' => "Nom d'utilisateur",
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-Z0-9_]{4,}$/",
                        'message' => "Le login doit contenir au moins 4 caractères et uniquement lettres, chiffres ou underscores."
                    ])
                ],
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Mot de passe*',
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le mot de passe est obligatoire."]),
                    new Assert\Regex([
                        'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/",
                        'message' => "Le mot de passe doit contenir au moins 12 caractères, dont une majuscule, une minuscule et un chiffre."
                    ])
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER'
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
