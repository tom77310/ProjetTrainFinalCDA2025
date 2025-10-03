<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use App\Form\ContactFormType;
use App\Form\InscriptionFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/utilisateurs')]
final class UtilisateursController extends AbstractController
{
    #[Route('/inscription', name: 'Utilisateur_Inscription')]
    public function InscriptionUtilisateur(Request $request, UserPasswordHasherInterface $hashpwd, ManagerRegistry $doctrine): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(InscriptionFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();

            $user->setCivilite($form->get('civilite')->getData());
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setDateNaissance($form->get('date_naissance')->getData());
            $user->setAdresse($form->get('adresse')->getData());
            $user->setCP($form->get('cp')->getData());
            $user->setVille($form->get('ville')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setLogin($form->get('login')->getData());
            
            $user->setPassword(
                $hashpwd->hashPassword($user, $form->get('password')->getData())
            );

            // Définir le rôle par défaut
            $roles = ['ROLE_USER'];

            // Vérifier si "admin" est dans le login ou le prénom
            if (
                false !== stripos($user->getLogin(), 'admin')
                || false !== stripos($user->getPrenom(), 'admin')
            ) {
                $roles = ['ROLE_ADMIN'];
            }

            $user->setRoles($roles);

            $em->persist($user);
            $em->flush();

             return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateurs/FormInscription.html.twig', [
            'f' => $form->createView(),
        ]);
    }

    
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, RateLimiterFactory $loginLimiter): Response
    {
        // On crée un "limiter" basé sur l'adresse IP du client
        $limiter = $loginLimiter->create($request->getClientIp());

        // On consomme 1 jeton pour chaque tentative
        $limit = $limiter->consume(1);

        // Si plus de jetons disponibles = tentative brute force → on bloque
        if (!$limit->isAccepted()) {
            throw $this->createAccessDeniedException('Trop de tentatives de connexion. Réessayez plus tard.');
        }

        // Récupère une éventuelle erreur de login
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier identifiant saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    
    
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

   #[Route('/contact', name: 'Utilisateur_contact')]
public function FormContact(Request $request, ManagerRegistry $doctrine, UtilisateurRepository $utilisateurRepository): Response
{
    $message = new Messages();
    $form = $this->createForm(ContactFormType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer l'email saisi
        $email = $form->get('email')->getData();

        // Ajouter l'email de l'expéditeur dans la description
        $message->setDescription($message->getDescription() . "\n\nEmail de l'expéditeur : " . $email);

        // Gérer la pièce jointe
        $file = $form->get('pieceJointe')->getData();
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('messages_directory'), $filename);
            $message->setPieceJointe($filename);
        }

        // Trouver tous les administrateurs et créer un message pour chacun
        $admins = $utilisateurRepository->findAll();
        $em = $doctrine->getManager();
        foreach ($admins as $admin) {
            if (in_array('ROLE_ADMIN', $admin->getRoles())) {
                $msgClone = clone $message;
                $msgClone->setDestinataire($admin);
                $em->persist($msgClone);
            }
        }

        $em->flush();

        $this->addFlash('success', 'Votre message a été envoyé aux administrateurs.');
        return $this->redirectToRoute('Utilisateur_contact');
    }

    return $this->render('utilisateurs/FormContact.html.twig', [
        'form' => $form->createView()
    ]);
}

}