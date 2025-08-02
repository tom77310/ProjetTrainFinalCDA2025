<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('civilite')
        ->add('nom')
        ->add('prenom')
        ->add('date_naissance', null, [
            'widget' => 'single_text',
            ])
        ->add('adresse')
        ->add('cp')
        ->add('ville')
        ->add('telephone')
        ->add('email')
        ->add('login')
        ->add('password')
        ->add('roles')
        ->add('save', SubmitType::class, [
            'label' => 'Inscription',
            'attr' => [
                'class' => 'inscription',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
