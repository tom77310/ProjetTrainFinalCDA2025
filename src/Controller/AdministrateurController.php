<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Messages;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\AdminMessageFormType;
use App\Form\AjoutUtilisateurFormType;
use App\Form\ModifUtilisateurFormType;
use App\Form\ProduitFormType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/administrateur')]
final class AdministrateurController extends AbstractController
{
    #[Route('/EspaceAdmin', name: 'Administrateur_EspaceAdmin')]
    public function EspaceAdmin(): Response
    {
        return $this->render('administrateur/EspaceAdmin.html.twig', [
            'controller_name' => 'AdministrateurController',
        ]);
    }
    // Boite de reception
    // Envoie d'un nouveau message
   #[Route('/boiteReception/NouveauMessage', name: 'Administrateur_EnvoyerMessage')]
    public function envoyerMessageAdmin(Request $request,EntityManagerInterface $em,SluggerInterface $slugger): Response
    {
        $message = new Messages();
        $form = $this->createForm(AdminMessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Définir l'expéditeur (admin connecté)
            $message->setExpediteur($this->getUser());

            // Gestion de la pièce jointe si fournie
            $pieceJointe = $form->get('pieceJointe')->getData();
            if ($pieceJointe) {
                $originalFilename = pathinfo($pieceJointe->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pieceJointe->guessExtension();

                // Déplacer le fichier dans le dossier uploads/messages
                try {
                    $pieceJointe->move(
                        $this->getParameter('messages_directory'), // paramètre à configurer
                        $newFilename
                    );
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de la pièce jointe.');
                    return $this->redirectToRoute('Administrateur_EnvoyerMessage');
                }

                // Stocker le nom du fichier dans l'entité (il faut ajouter un champ $pieceJointe dans Messages)
                $message->setPieceJointe($newFilename);
            }

            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Message envoyé à l\'utilisateur.');
            return $this->redirectToRoute('CompteUtilisateur_BoiteReception');
        }

        return $this->render('administrateur/BoiteReception/NouveauMessage.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // Liste des Utilisateurs
    #[Route('/ListeUtilisateurs', name: 'Administrateur_ListeUtilisateurs', methods: ['GET'])]
    public function ListeUtilisateur(UtilisateurRepository $UtilisateurRepository): Response
    {
        return $this->render('administrateur/GestionUtilisateurs/ListeUtilisateurs.html.twig', [
            'Utilisateurs' => $UtilisateurRepository->findAll(),
        ]);
    }

    // ajout d'un nouveau utilisateur
    #[Route('/Ajoututilisateur', name: 'Administrateur_AjoutUtilisateur', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Utilisateur = new Utilisateur();
        $form = $this->createForm(AjoutUtilisateurFormType::class, $Utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrateur/GestionUtilisateurs/AjoutUtilisateur.html.twig', [
            'Utilisateur' => $Utilisateur,
            'FormAjout' => $form,
        ]);
    }

    // Voir les details du utilisateur selectionné
    #[Route('/utilisateur/detail/{id}', name: 'Administrateur_DetailUtilisateur', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('administrateur/GestionUtilisateurs/DetailUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
// Modif utilisateur
    #[Route('/utilisateur/{id}/edit', name: 'Administrateur_ModifUtilisateur', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModifUtilisateurFormType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrateur/GestionUtilisateurs/ModifUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    // Supprimer un utilisateur
    #[Route('/utilisateur/supprimer/{id}', name: 'Administrateur_SupprimerUtilisateur', methods: ['POST', 'GET'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Administrateur_ListeUtilisateurs', [], Response::HTTP_SEE_OTHER);
    }

    // Gestion de stock de produits
    // Liste des produits
    #[Route('/ListeProduits', name: 'Administrateur_ListeProduits')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('administrateur/GestionProduits/ListeProduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    


    #[Route('/admin/produit/ajouter', name: 'Administrateur_AjoutProduit')]
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
            return $this->redirectToRoute('Administrateur_AjoutProduit');
        }

        return $this->render('administrateur/GestionProduits/AjoutProduit.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    // Voir le detail d'un produit spécifique
    #[Route('/DetailProduit/{id}', name: 'Administrateur_Detailproduit')]
    public function DetailProduit(Produit $produit): Response
    {
        return $this->render('administrateur/GestionProduits/DetailProduit.html.twig', [
            'produit' => $produit,
        ]);
    }
    // Modifier un produit spécifique
     #[Route('/ModifierProduit/{id}', name: 'Administrateur_ModifierProduit')]
    public function ModifierProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Produit modifié avec succès !');
            return $this->redirectToRoute('Administrateur_ListeProduits');
        }

        return $this->render('administrateur/GestionProduits/ModifierProduit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }
    // Supprimer un produit
    #[Route('/SupprimerProduit/{id}', name: 'Administrateur_SupprimerProduit', methods: ['POST'])]
    public function SupprimerProduit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $em->remove($produit);
            $em->flush();
            $this->addFlash('danger', 'Produit supprimé avec succès !');
        }

        return $this->redirectToRoute('Administrateur_ListeProduits');
    }

    // Historique de commande des utilisateurs 
    #[Route('/historiquecommandeUtilisateurs', name: 'admin_commandes')]
    public function HistoriqueCommandeUtilisateurs(CommandeRepository $commandeRepository): Response
    {
        // On récupère toutes les commandes
        $commandes = $commandeRepository->findAll();

        return $this->render('administrateur/GestionUtilisateurs/HistoriqueCommandesUtilisateurs.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/detailscommande/{id}', name: 'admin_commande_detail')]
    public function detail(Commande $commande): Response
    {
        return $this->render('administrateur/GestionUtilisateurs/DetailCommande.html.twig', [
            'commande' => $commande,
        ]);
    }


}
