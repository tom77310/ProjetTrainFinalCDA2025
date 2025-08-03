<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'label' => 'Objet',
                'attr' => ['placeholder' => 'Entrez l\'objet du message']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Décrivez votre demande']
            ])
            ->add('pieceJointe', FileType::class, [
                'label' => 'Pièce jointe (optionnel)',
                'required' => false,
                'mapped' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'mapped' => false,
                'attr' => ['placeholder' => 'exemple@domaine.com']
            ])
            ->add('login', TextType::class, [
                'label' => 'Votre login',
                'mapped' => false,
                'attr' => ['placeholder' => 'Votre identifiant']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}


