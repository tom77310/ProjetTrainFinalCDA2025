<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Entity\Messages;
use App\Entity\Produit;
use App\Form\AdminMessageFormType;
use App\Form\MessageFormType;
use App\Form\ModifInfosPersosFormType;
use App\Form\RetractationFormType;
use App\Repository\MessagesRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/compte')]
final class CompteController extends AbstractController
{
    #[Route('/espacecompte', name: 'Compte_Espace')]
    public function espace(): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        
        // Détermine le rôle pour adapter l'affichage
        if ($this->isGranted('ROLE_ADMIN')) {
            $role = 'admin';
            $controllerName = 'CompteController (admin)'; 
        } else {
            $role = 'user';
            $controllerName = 'CompteController';
        }
        
        // Un seul render pour tous les rôles
        return $this->render('Compte/espaceCompte.html.twig', [
            'role' => $role,
            'controller_name' => $controllerName,
        ]);
    }


    // Compte Utilisateur
        // Infos Personnelles Utilisateurs
            #[Route('/utilisateur/infospersos', name: 'Compte_infosPersos')]
            public function InfosPersos(): Response
            {
                return $this->render('Compte/utilisateurs/infospersos.html.twig', [
                    'controller_name' => 'CompteController',
                ]);
            }
            // Modification Infos Personnelles utilisateurs
            #[Route('/utilisateur/modifInfosPersos', name: 'Compte_modifInfos')]
            public function ModifInfosPersos(Request $req,EntityManagerInterface $manager): Response
            {
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

                    return $this->redirectToRoute('Compte_infosPersos');
                }

                return $this->render('Compte/utilisateurs/ModifInfosPersos.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        // Fin Informations Utilisateurs
        // Formulaire de Retractation Utilisateur
            #[Route('/utilisateur/formRetractation', name: 'Compte_FormRetractation')]
            public function FormRetractation(Request $request, ManagerRegistry $doctrine, UtilisateurRepository $utilisateurRepository): Response
            {
                $message = new Messages();
                $form = $this->createForm(RetractationFormType::class, $message);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $doctrine->getManager();

                    $user = $this->getUser();
                    if (!$user) {
                        $this->addFlash('error', 'Vous devez être connecté pour envoyer un message.');
                        return $this->redirectToRoute('app_login');
                    }

                    // Associer l'expéditeur
                    $message->setExpediteur($user);

                    // Gérer la pièce jointe
                    $file = $form->get('pieceJointe')->getData();
                    if ($file) {
                        $newFilename = uniqid().'.'.$file->guessExtension();
                        $file->move($this->getParameter('messages_directory'), $newFilename);
                        $message->setPieceJointe($newFilename);
                    }

                    // Récupérer tous les utilisateurs et filtrer les admins en PHP
                    $allUsers = $utilisateurRepository->findAll();
                    $admins = [];
                    foreach ($allUsers as $admin) {
                        if (in_array('ROLE_ADMIN', $admin->getRoles(), true)) {
                            $admins[] = $admin;
                        }
                    }

                    if (empty($admins)) {
                        $this->addFlash('error', 'Aucun administrateur trouvé.');
                        return $this->redirectToRoute('Compte_FormRetractation');
                    }

                    // Cloner et persister...
                    foreach ($admins as $admin) {
                        $msgClone = clone $message;
                        $msgClone->setDestinataire($admin);
                        $em->persist($msgClone);
                    }

                    $em->flush();

                    $this->addFlash('success', 'Votre message a été envoyé aux administrateurs.');
                    return $this->redirectToRoute('Compte_FormRetractation');
                }

                    return $this->render('Compte/utilisateurs/formRetractation.html.twig', [
                        'f' => $form->createView()
                    ]);
            }
        // Fin Formulaire de Retractation
        // Boite de reception
            // Affichage boite de reception
                #[Route('/BoiteReception', name: 'Compte_BoiteReception')]
                public function BoiteReception(MessagesRepository $messageRepository, Security $security): Response
                {
                    // Récupérer l'utilisateur connecté
                    $user = $security->getUser();

                    // Messages reçus
                $messagesRecus = $messageRepository->findBy(
                ['destinataire' => $user],
                    ['id' => 'DESC'],
                    3
                );

                    // Messages envoyés
                    $messagesEnvoyes = $messageRepository->findBy(
                    ['expediteur' => $user],
                    ['id' => 'DESC'],
                    3
                );

                    return $this->render('Compte/BoiteReception/BoiteReception.html.twig', [
                        'messagesRecus' => $messagesRecus,
                        'messagesEnvoyes' => $messagesEnvoyes,
                    ]);
                }

            // Messages recus
                #[Route('/utilisateur/messagerecus', name: 'Compte_UtilisateurBoiteReceptionMesssageRecus')]
                #[Route('/administrateur/messagerecus', name: 'Compte_AdministrateurBoiteReceptionMesssageRecus')]
                public function MessageRecus(MessagesRepository $messagesRepository): Response
                {
                    $user = $this->getUser();
                    $messages = $messagesRepository->findBy(['destinataire' => $user]);

                    return $this->render('Compte/BoiteReception/MessageRecus.html.twig', [
                        'messages' => $messages,
                    ]);
                }
            // Message Envoyer
                #[Route('/utilisateur/messageEnvoyer', name: 'Compte_UtilisateurMessageEnvoyer')]
                #[Route('/administrateur/messageEnvoyer', name: 'Compte_AdministrateurMessageEnvoyer')]
                public function MessageEnvoyer(MessagesRepository $messagesRepository): Response
                {
                    $user = $this->getUser();
                    $messages = $messagesRepository->findBy(['expediteur' => $user]);

                    return $this->render('Compte/BoiteReception/MessageEnvoyer.html.twig', [
                        'messages' => $messages,
                    ]);
                }
            // Detail d'un message reçu spécifique
                #[Route('/utilisateur/DetailMessage/{id}', name: 'Compte_UtilisateurDetailMessage', requirements: ['id' => '\d+'])]
                #[Route('/administrateur/DetailMessage/{id}', name: 'Compte_AdministrateurDetailMessage', requirements: ['id' => '\d+'])]
                public function DetailMessage(Messages $message): Response
                {
                    // Sécurité : seul destinataire ou expéditeur peut voir le message
                    $user = $this->getUser();
                    if ($message->getDestinataire() !== $user && $message->getExpediteur() !== $user) {
                        throw $this->createAccessDeniedException("Vous n'avez pas accès à ce message.");
                    }

                    return $this->render('Compte/BoiteReception/DetailMessage.html.twig', [
                        'message' => $message,
                    ]);
                }
                
            // Envoyer un nouveau message
            #[Route('/utilisateur/EnvoieMessage', name: 'Compte_UtilisateurEnvoieMessage')]
            #[Route('/administrateur/EnvoieMessage', name: 'Compte_AdministrateurEnvoieMessage')]
            public function EnvoyerUnMessage(Request $request,EntityManagerInterface $em,UtilisateurRepository $utilisateurRepository,SluggerInterface $slugger): Response {
                $user = $this->getUser();
                $message = new Messages();

                // Choix du formulaire selon le rôle
                if ($this->isGranted('ROLE_ADMIN')) {
                    $form = $this->createForm(AdminMessageFormType::class, $message);
                    $role = 'admin';
                } else {
                    $form = $this->createForm(MessageFormType::class, $message);
                    $role = 'user';
                }

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $message->setExpediteur($user);

                    // Gestion pièce jointe
                    $file = $form->get('pieceJointe')->getData();
                    if ($file) {
                        if ($role === 'admin') {
                            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $safeFilename = $slugger->slug($originalFilename);
                            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                        } else {
                            $newFilename = uniqid().'.'.$file->guessExtension();
                        }

                        try {
                            $file->move($this->getParameter('messages_directory'), $newFilename);
                            $message->setPieceJointe($newFilename);
                        } catch (\Exception $e) {
                            $this->addFlash('error', 'Erreur lors de l\'upload de la pièce jointe.');
                            return $this->redirectToRoute($role === 'admin' ? 'Compte_AdministrateurEnvoieMessage' : 'Compte_UtilisateurEnvoieMessage');
                        }
                    }

                    // Logique différente
                    if ($role === 'admin') {
                        $em->persist($message);
                        $this->addFlash('success', 'Message envoyé à l\'utilisateur.');
                    } else {
                        $admins = $utilisateurRepository->findAll();
                        foreach ($admins as $admin) {
                            if (in_array('ROLE_ADMIN', $admin->getRoles())) {
                                $msgClone = clone $message;
                                $msgClone->setDestinataire($admin);
                                $em->persist($msgClone);
                            }
                        }
                        $this->addFlash('success', 'Votre message a été envoyé aux administrateurs.');
                    }
                    if ($this->isGranted('ROLE_ADMIN')) {
                        $form = $this->createForm(AdminMessageFormType::class, $message, ['show_destinataire' => true]);
                        $role = 'admin';
                    } else {
                        $form = $this->createForm(MessageFormType::class, $message);
                        $role = 'user';
                    }

                    $em->flush();
                    
                       return $this->redirectToRoute('Compte_BoiteReception');

                }

                // Un seul render
                return $this->render('Compte/BoiteReception/NouveauMessage.html.twig', [
                    'form' => $form->createView(),
                    'role' => $role,
                ]);
            }
// Reponse a un message
#[Route('/utilisateur/Message/{id}/reponse', name: 'Compte_UtilisateurReponseMessage', requirements: ['id' => '\d+'])]
#[Route('/administrateur/Message/{id}/reponse', name: 'Compte_AdministarteurReponseMessage', requirements: ['id' => '\d+'])]
public function ReponseMessage(Messages $original, Request $request, EntityManagerInterface $em): Response {
    $reply = new Messages();
    $reply->setExpediteur($this->getUser());
    $reply->setDestinataire($original->getExpediteur()); // destinataire fixe
    $reply->setObjet("Re: " . $original->getObjet());

    // Choisir le formulaire selon le rôle
    if ($this->isGranted('ROLE_ADMIN')) {
        $form = $this->createForm(AdminMessageFormType::class, $reply, [
            'show_destinataire' => true,  // afficher le destinataire comme rappel
            'readonly' => true,           // lecture seule
        ]);
    } else {
        $form = $this->createForm(MessageFormType::class, $reply);
    }

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Gestion de la pièce jointe
        $file = $form->get('pieceJointe')->getData();
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('messages_directory'), $filename);
            $reply->setPieceJointe($filename);
        }

        $em->persist($reply);
        $em->flush();

        $this->addFlash('success', 'Votre réponse a été envoyée.');
        return $this->redirectToRoute('Compte_BoiteReception');
    }

    return $this->render('Compte/BoiteReception/NouveauMessage.html.twig', [
        'form' => $form->createView(),
    ]);
}

        // Fin Boite de Reception
        // Panier
            // Affichage Panier
            #[Route('/utilisateur/panier', name: 'Compte_UtilisateurPanier')]
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
                return $this->render('Compte/utilisateurs/panier.html.twig', compact("dataPanier", "total"));
            }

            // Ajout un produit au panier
            #[Route('/utilisateur/panier/ajoutpanier/{id}', name: 'Compte_UtilisateurAjoutPanier')]
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
                return $this->redirectToRoute('Compte_UtilisateurPanier');
            }

            // Diminuer la quantité d'un produit dans le panier (et quand quantite = 0 => le produit est supprimer du panier)
            #[Route('/utilisateur/panier/diminuerquantite/{id}', name: 'Compte_UtilisateurDiminuerQuantite')]
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
            return $this->redirectToRoute('Compte_UtilisateurPanier');
            }

            // Supprimer un produit avec un boutton supprimer
            #[Route('/utilisateur/panier/supprimerProduit/{id}', name: 'Compte_UtilisateurSupprimerProduit')]
            public function SupprimerProduit(Produit $produits, SessionInterface $session):Response
            {       
            $id = $produits->getId();

            $panier = $session->get("panier", []);
                    
            if(!empty($panier[$id])){

                    unset($panier[$id]);
                }
                
                $session->set("panier", $panier);

                return $this->redirectToRoute('Compte_UtilisateurPanier');
            }

            // Supprimer le panier en entier
            #[Route('/utilisateur/panier/supprimerPanier', name: 'Compte_UtilisateurSupprimerPanier')]
            public function SupprimerPanier(SessionInterface $session):Response
            {                  
            $session->remove("panier");
                
            return $this->redirectToRoute('Compte_UtilisateurPanier');
            }
        //Fin Panier
        
        // Commande 
      #[Route('/utilisateur/commande', name: 'Compte_UtilisateurCommande')]
public function Commande(
    SessionInterface $session,
    ProduitRepository $produitRepository,
    EntityManagerInterface $em
): Response {
    $this->denyAccessUnlessGranted('ROLE_USER');

    $panier = $session->get('panier', []);

    if ($panier === []) {
        $this->addFlash('warning', 'Votre panier est vide.');
        return $this->redirectToRoute('acceuil_index');
    }

    try {
        // Créer la commande
        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());
        $commande->setReference(uniqid());

        foreach ($panier as $idProduit => $quantite) {
            $produit = $produitRepository->find($idProduit);

            if (!$produit) {
                throw new \Exception("Le produit ID $idProduit n'existe pas.");
            }

            // Vérifier le stock disponible
           if ($produit->getStock() < $quantite) {
            $this->addFlash('warning', "Stock insuffisant pour le produit " . $produit->getNomProduit());
            return $this->redirectToRoute('Compte_UtilisateurPanier');
}


            // Décrémenter le stock
            $produit->setStock($produit->getStock() - $quantite);

            // Créer la ligne de commande
            $ligne = new LigneDeCommande();
            $ligne->setProduit($produit);
            $ligne->setPrixUnitaireProduit((int)$produit->getPrix()); 
            $ligne->setQuantiteCommande($quantite);
            $ligne->setCommande($commande);

            $commande->addLigneDeCommande($ligne);

            // Pas besoin de persist($ligne) séparé : cascade peut suffire
            $em->persist($ligne);
        }

        $em->persist($commande);
        $em->flush();

        // Vider le panier
        $session->remove('panier');

        $this->addFlash('success', 'Votre commande a été validée avec succès !');

        return $this->redirectToRoute('Compte_UtilisateurDetailCommande', [
            'id' => $commande->getId(),
        ]);
    } catch (\Exception $e) {
        $this->addFlash('danger', "Erreur lors de la validation : " . $e->getMessage());
        return $this->redirectToRoute('Compte_UtilisateurPanier');
    }
}


    
    // Affiche le details de la commande
    #[Route('/utilisateur/commande/detailscommande/{id}', name: 'Compte_UtilisateurDetailCommande', requirements: ['id' => '\d+'])]
    #[Route('/administrateur/commande/detailscommande/{id}', name: 'Compte_AdministrateurDetailCommande', requirements: ['id' => '\d+'])]
    public function DetailCommande(Commande $commande, Request $request): Response
    {
        $user = $this->getUser();

        // Si la route est pour un utilisateur
        if ($request->attributes->get('_route') === 'Compte_UtilisateurDetailCommande') {
            $this->denyAccessUnlessGranted('ROLE_USER');

            if ($commande->getUtilisateur() !== $user) {
                throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande.");
            }
        }

        // Si la route est pour un admin
        if ($request->attributes->get('_route') === 'Compte_AdministrateurDetailCommande') {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        if (!$commande) {
            throw $this->createNotFoundException("Commande introuvable");
        }

        return $this->render('Compte/commande/DetailCommande.html.twig', [
            'commande' => $commande,
            'isAdmin' => $request->attributes->get('_route') === 'Compte_AdministrateurDetailCommande'
        ]);
    }


    // afficher l'historique des commandes des utilisateurs
    #[Route('/utilisateur/commande/historique', name: 'Compte_UtilisateurHistoriqueCommande')]
#[Route('/administrateur/historiquecommandeUtilisateurs', name: 'Compte_AdministrateurHistoriquesCommandesUtilisateurs')]
public function historiqueCommande(EntityManagerInterface $em, Request $request): Response
{
    $route = $request->attributes->get('_route');

    // Si l'utilisateur consulte son propre historique
    if ($route === 'Compte_UtilisateurHistoriqueCommande') {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $commandes = $em->getRepository(Commande::class)->findBy(
            ['utilisateur' => $this->getUser()],
            ['id' => 'DESC']
        );
    } 
    // Si l'admin consulte l'historique global
    else {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $commandes = $em->getRepository(Commande::class)->findBy([], ['id' => 'DESC']);
    }

    return $this->render('Compte/commande/historique.html.twig', [
        'commandes' => $commandes,
        'isAdmin'   => $route === 'Compte_AdministrateurHistoriquesCommandesUtilisateurs'
    ]);
}


}
