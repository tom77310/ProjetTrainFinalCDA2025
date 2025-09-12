<?php
namespace App\Form;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AdminMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'label' => 'Objet',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('destinataire', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'email', // Affiche l'email de l'utilisateur
                'label' => 'Envoyer à',
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('u')
                        ->where('u.roles NOT LIKE :role') // exclut les admins
                        ->setParameter('role', '%ROLE_ADMIN%')
                        ->orderBy('u.email', 'ASC'); // tri par email
                },
            ])
            ->add('pieceJointe', FileType::class, [
                'label' => 'Pièce jointe (facultatif)',
                'mapped' => false,          // pas directement lié à l'entité Messages
                'required' => false,        // pas obligatoire
                'constraints' => [
                    new File([
                        'maxSize' => '5M', // taille max 5Mo
                        'mimeTypes' => [
                            'application/pdf',
                            'image/*',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier valide (PDF, image, Word).',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
