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
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => 'Prénom*',
            ])
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'required' => false,
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => 'Adresse postale*',
            ])
            ->add('cp', NumberType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('telephone', NumberType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email*',
            ])
            ->add('login', TextType::class, [
                'label' => "Nom d'utilisateur",
                'required' => false,
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Mot de passe*',
                'attr' => [
                    'minlength' => '12',
                    'pattern' => '[a-zA-Z0-9]{12,50}',
                ]
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
