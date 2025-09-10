<?php
namespace App\Form;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Message',
            ])
            ->add('destinataire', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'email', // Affiche l'email de l'utilisateur
                'label' => 'Envoyer à',
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('u')
                        ->where('JSON_CONTAINS(u.roles, :role) = 0')
                        ->setParameter('role', '"ROLE_ADMIN"'); // exclut les admins
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
