<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifUtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nom', TextType::class, [
            'attr' => [
                'class' => 'Nom',
            ]
        ])
        ->add('Prenom', TextType::class, [
            'attr' => [
                'class' => 'Prenom',
            ]
        ])
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'Email',
            ]
        ])
        ->add('adresse', TextType::class, [
            'attr' => [
                'class' => 'Adresse',
            ]
        ])
        ->add('cp', NumberType::class, [
            'attr' => [
                'class' => 'CodePostal',
            ],
                'label' => 'Code Postal',
        ])
        ->add('Ville', TextType::class, [
            'attr' => [
                'class' => 'Ville',
            ]
        ])
        ->add('telephone', NumberType::class, [
            'attr' => [
                'class' => 'Telephone',
            ]
        ])
        ->add('roles', ChoiceType::class, [
            'required' => true,
            'multiple' => true,
            'expanded' => false,
                'attr' => [
                    'class' => 'Role',
                ],
            'choices' => [
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER'
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
