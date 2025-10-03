<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Utilisateur;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use Symfony\Component\Form\FormTypeInterface;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifInfosPersosFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nom', TextType::class, [
            'attr' => [
                'class' => 'Nom',
                'required' =>'false',
            ]
        ] )
        ->add('Prenom', TextType::class, [
            'attr' => [
                'class' => 'Prenom',
                'required' =>'false',
            ]
        ] )
            ->add('Email', EmailType::class, [
                'attr' => [
                    'class' => 'Email',
                    'required' =>'false',
                ]
            ] )
            ->add('Adresse', TextType::class, [
                'attr' => [
                    'class' => 'Adresse',
                    'required' =>'false',
                ]
            ] )
            ->add('CP', NumberType::class, [
                'attr' => [
                    'minlength' => '1', 
                    'maxlength' => '5',
                    'class' => 'Code_Postale',
                    'required' =>'false',
                ],
            'label' => 'Code Postal'])
            
            ->add('Ville', TextType::class, [
                'attr' => [
                    'class' => 'Ville',
                    'required' =>'false',
                ]
            ] )
            ->add('Telephone', TextType::class,  [
                'attr' => [
                    'minlength' => '1',
                    'maxlength' => '10',
                    'class' => 'Telephone',
                    'required' =>'false',
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder les modifications',
                'attr' => ['class' => 'Modifier']
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
