<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\AjoutUtilisateurFormType;
use App\Form\ModifUtilisateurFormType;
use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte')]
final class AdministrateurController extends AbstractController
{
    // Liste des Utilisateurs
    #[Route('/administrateur/ListeUtilisateurs', name: 'Administrateur_ListeUtilisateurs', methods: ['GET'])]
    public function ListeUtilisateur(UtilisateurRepository $UtilisateurRepository): Response
    {
        return $this->render('Compte/administrateur/GestionUtilisateurs/ListeUtilisateurs.html.twig', [
            'Utilisateurs' => $UtilisateurRepository->findAll(),
        ]);
    }

    // ajout d'un nouveau utilisateur
    #[Route('/administrateur/Ajoututilisateur', name: 'Administrateur_AjoutUtilisateur', methods: ['GET', 'POST'])]
    public function AjoutUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Utilisateur = new Utilisateur();
        $form = $this->createForm(AjoutUtilisateurFormType::class, $Utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Compte/administrateur/GestionUtilisateurs/AjoutUtilisateur.html.twig', [
            'Utilisateur' => $Utilisateur,
            'FormAjout' => $form,
        ]);
    }

    // Voir les details du utilisateur selectionné
    #[Route('/administrateur/detailutilisateur/{id}', name: 'Administrateur_DetailUtilisateur', methods: ['GET'])]
    public function DetailUtilisateur(Utilisateur $utilisateur): Response
    {
        return $this->render('Compte/administrateur/GestionUtilisateurs/DetailUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
// Modif utilisateur
    #[Route('/administrateur/modifierUtilisateur/{id}', name: 'Administrateur_ModifUtilisateur', methods: ['GET', 'POST'])]
    public function ModifierUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModifUtilisateurFormType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Compte/administrateur/GestionUtilisateurs/ModifUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    // Supprimer un utilisateur
    #[Route('/administrateur/supprimerUtilisateur/{id}', name: 'Administrateur_SupprimerUtilisateur', methods: ['POST', 'GET'])]
    public function SupprimerUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
    }

    // Gestion de stock de produits
    // Liste des produits
    #[Route('/administrateur/ListeProduits', name: 'Administrateur_ListeProduits')]
    public function ListeProduit(ProduitRepository $produitRepository): Response
    {
        return $this->render('Compte/administrateur/GestionProduits/ListeProduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    


    #[Route('/administrateur/ajouterProduit', name: 'Administrateur_AjoutProduit')]
    public function ajouterProduit(Request $request, EntityManagerInterface $em): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion upload des images
            foreach (['vue1', 'vue2', 'vue3'] as $field) {
                $file = $form->get($field)->getData();
                if ($file) {
                    $fileName = uniqid().'.'.$file->guessExtension();
                    try {
                        $file->move($this->getParameter('messages_directory'), $fileName);
                    } catch (FileException $e) {
                        throw new \Exception("Erreur upload image : " . $e->getMessage());
                    }
                    $setter = 'set' . ucfirst($field);
                    $produit->$setter($fileName);
                }
            }

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');
            return $this->redirectToRoute('Administrateur_ListeProduits');
        }

        return $this->render('Compte/administrateur/GestionProduits/AjoutProduit.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    // Voir le detail d'un produit spécifique
    #[Route('/administrateur/DetailProduit/{id}', name: 'Administrateur_Detailproduit')]
    public function DetailProduit(Produit $produit): Response
    {
        return $this->render('Compte/administrateur/GestionProduits/DetailProduit.html.twig', [
            'produit' => $produit,
        ]);
    }
    // Modifier un produit spécifique
     #[Route('/administrateur/ModifierProduit/{id}', name: 'Administrateur_ModifierProduit')]
    public function ModifierProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Produit modifié avec succès !');
            return $this->redirectToRoute('Administrateur_ListeProduits');
        }

        return $this->render('Compte/administrateur/GestionProduits/ModifierProduit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }
    // Supprimer un produit
    #[Route('/administrateur/SupprimerProduit/{id}', name: 'Administrateur_SupprimerProduit', methods: ['POST'])]
    public function SupprimerProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $em->remove($produit);
            $em->flush();
            $this->addFlash('danger', 'Produit supprimé avec succès !');
        }

        return $this->redirectToRoute('Administrateur_ListeProduits');
    }
}