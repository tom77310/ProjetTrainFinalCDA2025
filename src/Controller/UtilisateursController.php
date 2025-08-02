<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

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
            $user->setCivilite($form->get("civilite")->getData());
            $user->setNom($form->get("nom")->getData());
            $user->setPrenom($form->get("prenom")->getData());
            $user->setDateNaissance($form->get("date_naissance")->getData());
            $user->setAdresse($form->get("adresse")->getData());
            $user->setCP($form->get("cp")->getData());
            $user->setVille($form->get("ville")->getData());
            $user->setTelephone($form->get("telephone")->getData());
            $user->setEmail($form->get("email")->getData());
            $user->setLogin($form->get("login")->getData());
            $user->setPassword($hashpwd->hashPassword($user, $form->get("password")->getData()));
            $user->setRoles($form->get("roles")->getData());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateurs/FormInscription.html.twig', [
            'f' => $form->createView()
        ]);
    }
}
