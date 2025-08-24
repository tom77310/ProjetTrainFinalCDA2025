<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Messages;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\ModifInfosPersosFormType;
use App\Form\RetractationFormType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/compte')]
final class CompteUtilisateurController extends AbstractController
{
    #[Route('/', name: 'CompteUtilisateur_moncompte')]
    public function index(): Response
    {
        return $this->render('compte_utilisateur/moncompte.html.twig', [
            'controller_name' => 'CompteUtilisateurController',
        ]);
    }
    #[Route('/infospersos', name: 'CompteUtilisateur_infosPersos')]
    public function InfosPersos(): Response
    {
        return $this->render('compte_utilisateur/infospersos.html.twig', [
            'controller_name' => 'CompteUtilisateurController',
        ]);
    }
    #[Route('/modifInfosPersos', name: 'CompteUtilisateur_modifInfos')]
public function ModifInfosPersos(Request $req, ManagerRegistry $doctrine, EntityManagerInterface $manager): Response
{
    /** @var Utilisateur $user */
    $user = $this->getUser();

    // Vérification si l'utilisateur est bien connecté
    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    // Création du formulaire avec l'utilisateur connecté
    $form = $this->createForm(ModifInfosPersosFormType::class, $user);
    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($user); // pas forcément nécessaire si $user vient déjà de Doctrine
        $manager->flush();

        return $this->redirectToRoute('CompteUtilisateur_infosPersos');
    }

    return $this->render('compte_utilisateur/ModifInfosPersos.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/historique', name: 'CompteUtilisateur_HistoriqueCommande')]
    public function HistoriqueCommandes(): Response
    {
        return $this->render('compte_utilisateur/historique.html.twig', [
            'controller_name' => 'CompteUtilisateurController',
        ]);
    }


    #[Route('/formRetractation', name: 'CompteUtilisateur_FormRetractation')]
    public function FormRetractation(Request $request, ManagerRegistry $doctrine): Response
    {
        $message = new Messages();
        $form = $this->createForm(RetractationFormType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer email et login du formulaire
            $email = $form->get('email')->getData();
            $login = $form->get('login')->getData();

            // Chercher l'utilisateur correspondant
            $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy([
                'email' => $email,
                'login' => $login
            ]);

            if (!$utilisateur) {
                $this->addFlash('error', 'Utilisateur non trouvé');
                return $this->redirectToRoute('acceuil_index');
            }

            // Associer l'utilisateur au message
            $message->setUtilisateur($utilisateur);

            // Gérer la pièce jointe
            $file = $form->get('pieceJointe')->getData();
            if ($file) {
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move($this->getParameter('messages_directory'), $newFilename);
                $message->setPieceJointe($newFilename);
            }

            // Sauvegarder
            $em = $doctrine->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Message envoyé avec succès !');
            return $this->redirectToRoute('CompteUtilisateur_FormRetractation');
        }

        return $this->render('compte_utilisateur/formRetractation.html.twig', [
            'f' => $form->createView()
        ]);
    }


    #[Route('/BoiteReception', name: 'CompteUtilisateur_BoiteReception')]
    public function BoiteReception(): Response
    {
        return $this->render('compte_utilisateur/BoiteReception.html.twig', [
            'controller_name' => 'CompteUtilisateurController',
        ]);
    }

    // Panier
    // Affichage Panier
        #[Route('/panier', name: 'CompteUtilisateur_Panier')]
    public function AfficherPanier(SessionInterface $session, ProduitRepository $produitsRepository):Response
    {
        $panier=$session->get('panier', []);
        $dataPanier = [];
        $total =0;

        foreach($panier as $id => $quantite){
            $produits = $produitsRepository->find($id);
            $dataPanier[] = [
                "produit" => $produits, 
                "quantite" => $quantite
            ];
            $total += $produits->getPrix() * $quantite;
        }
        return $this->render('compte_utilisateur/panier/panier.html.twig', compact("dataPanier", "total"));
    }

    // Ajout un produit au panier
    #[Route('/ajoutpanier/{id}', name: 'CompteUtilisateur_AjoutPanier')]
    public function AjoutPanier(Produit $produits, SessionInterface $session):Response
    {
       
        $id = $produits->getId();

        $panier = $session->get("panier", []);
        
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute('CompteUtilisateur_Panier');
    }

    // Diminuer la quantité d'un produit dans le panier (et quand quantite = 0 => le produit est supprimer du panier)
    #[Route('/diminuer/{id}', name: 'CompteUtilisateur_DiminuerQuantite')]
    public function DiminuerQuantite(Produit $produits, SessionInterface $session):Response
    {
        $id = $produits->getId();

        $panier = $session->get("panier", []);
               
        if(!empty($panier[$id])){

            if($panier[$id]>1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }            
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute('CompteUtilisateur_Panier');
    }

    // Supprimer un produit avec un boutton supprimer
    #[Route('/supprimer/{id}', name: 'CompteUtilisateur_SupprimerProduit')]
    public function SupprimerProduit(Produit $produits, SessionInterface $session):Response
    {       
        $id = $produits->getId();

        $panier = $session->get("panier", []);
                
        if(!empty($panier[$id])){

                unset($panier[$id]);
            }
            
            $session->set("panier", $panier);

            return $this->redirectToRoute('CompteUtilisateur_Panier');
    }

    // Supprimer le panier en entier
    #[Route('/supprimerPanier', name: 'CompteUtilisateur_SupprimerPanier')]
    public function SupprimerPanier(SessionInterface $session):Response
    {                  
      $session->remove("panier");
        
      return $this->redirectToRoute('CompteUtilisateur_Panier');
    }
    // Commande utilisateur
    #[Route('/commande', name: 'CompteUtilisateur_Commande')]
        public function Commande(SessionInterface $session, ProduitRepository $produitRepository, CommandeRepository $commandeReposiory, EntityManagerInterface $em):Response
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
    
            $panier = $session->get('panier', []);
    
            if($panier === []){
                $this->addFlash('message', 'Votre panier est vide');
                return $this->redirectToRoute('app_acceuil');
            }
    
            //Le panier n'est pas vide, on crée la commande
            $commande = new Commande();
    
            // On remplit la commande
            $commande->setUtilisateur($this->getUser());
            $commande->setReference(uniqid(2));
    
            // On parcourt le panier pour créer les détails de commande
            foreach($panier as $item => $quantite){
                $DetailCommande = new Commande();
    
                // On va chercher le produit
                $produit = $produitRepository->find($item);
                $commande = $commandeReposiory->find($item);
                
                // $prix = $produit->getPrix();
                // $quantitecommande = $produit->setQuantite();
                // $reference = $commande->setReference(uniqid(1));

                // On crée le détail de commande
                $DetailCommande->setProduits($produit);
                // $produit->setPrix($prix);
                // $produit->setQuantite($quantitecommande);
                // $DetailCommande->setReference($commande);
    
                // $commande->addProduit($DetailCommande);
            }
    
            // On persiste et on flush
            $em->persist($commande); // persist => prépare les données lors de la création de la requete
            $em->flush(); // flush => sauvegarde les infos dans la base de données
    
            $session->remove('panier');
    
           // $this->addFlash('message', 'Commande validée'); // sencé afficher un message apres avoir valider la commande dans le panier
            // return $this->redirectToRoute('CompteUtilisateur_Panier');
            return $this->render('compte_utilisateur/commande/commande.html.twig');
        }
}
