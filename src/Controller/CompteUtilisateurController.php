<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Entity\Messages;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\ContactFormType;
use App\Form\MessageFormType;
use App\Form\ModifInfosPersosFormType;
use App\Form\RetractationFormType;
use App\Repository\CommandeRepository;
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


   #[Route('/formRetractation', name: 'CompteUtilisateur_FormRetractation')]
public function FormRetractation(Request $request, ManagerRegistry $doctrine, UtilisateurRepository $utilisateurRepository): Response
{
    $message = new Messages();
    $form = $this->createForm(RetractationFormType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();

        /** @var \App\Entity\Utilisateur $user */
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
    return $this->redirectToRoute('CompteUtilisateur_FormRetractation');
}

// Cloner et persister...
foreach ($admins as $admin) {
    $msgClone = clone $message;
    $msgClone->setDestinataire($admin);
    $em->persist($msgClone);
}

        $em->flush();

        $this->addFlash('success', 'Votre message a été envoyé aux administrateurs.');
        return $this->redirectToRoute('CompteUtilisateur_FormRetractation');
    }

    return $this->render('compte_utilisateur/formRetractation.html.twig', [
        'f' => $form->createView()
    ]);
}


    // Boite de reception
// Affichage boite de reception
#[Route('/utilisateur/BoiteReception', name: 'CompteUtilisateur_BoiteReception')]
#[Route('/admin/BoiteReception', name: 'Administrateur_BoiteReception')]
public function BoiteReception(): Response
{
    return $this->render('compte_utilisateur/BoiteReception/BoiteReception.html.twig');
}

// Messages recus
#[Route('/messagerecus', name: 'CompteUtilisateur_BoiteReceptionMesssageRecus')]
    public function received(MessagesRepository $messagesRepository): Response
    {
        $user = $this->getUser();
        $messages = $messagesRepository->findBy(['destinataire' => $user]);

        return $this->render('compte_utilisateur/BoiteReception/MessageRecus.html.twig', [
            'messages' => $messages,
        ]);
    }
// Message Envoyer
  #[Route('/messageEnvoyer', name: 'messages_sent')]
    public function sent(MessagesRepository $messagesRepository): Response
    {
        $user = $this->getUser();
        $messages = $messagesRepository->findBy(['expediteur' => $user]);

        return $this->render('compte_utilisateur/BoiteReception/MessageEnvoyer.html.twig', [
            'messages' => $messages,
        ]);
    }
// Detail d'un message reçu spécifique
    #[Route('/DetailMessage/{id}', name: 'messages_detail', requirements: ['id' => '\d+'])]
    public function detail(Messages $message): Response
    {
        // Sécurité : seul destinataire ou expéditeur peut voir le message
        $user = $this->getUser();
        if ($message->getDestinataire() !== $user && $message->getExpediteur() !== $user) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à ce message.");
        }

        return $this->render('compte_utilisateur/BoiteReception/DetailMessage.html.twig', [
            'message' => $message,
        ]);
    }
// Envoyer un nouveau message
// Envoyer un nouveau message
#[Route('/NouveauMessage', name: 'messages_new')]
public function new(
    Request $request,
    EntityManagerInterface $em,
    UtilisateurRepository $utilisateurRepository
): Response {
    $message = new Messages();
    $form = $this->createForm(MessageFormType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // l’expéditeur est toujours l’utilisateur connecté
        $expediteur = $this->getUser();
        $message->setExpediteur($expediteur);

        // Gestion de la pièce jointe
        $file = $form->get('pieceJointe')->getData();
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('messages_directory'), $filename);
            $message->setPieceJointe($filename);
        }

        // Envoi automatique à tous les administrateurs
        $admins = $utilisateurRepository->findAll();
        foreach ($admins as $admin) {
            if (in_array('ROLE_ADMIN', $admin->getRoles())) {
                $msgClone = clone $message;
                $msgClone->setDestinataire($admin);
                $em->persist($msgClone);
            }
        }

        $em->flush();

        $this->addFlash('success', 'Votre message a été envoyé aux administrateurs.');
        return $this->redirectToRoute('CompteUtilisateur_BoiteReception');
    }

    return $this->render('compte_utilisateur/BoiteReception/NouveauMessage.html.twig', [
        'form' => $form->createView(),
    ]);
}




// Réponse à un message
#[Route('Message/{id}/reponse', name: 'messages_reply', requirements: ['id' => '\d+'])]
public function reply(
    Messages $original,
    Request $request,
    EntityManagerInterface $em
): Response {
    $reply = new Messages();
    $reply->setExpediteur($this->getUser());
    $reply->setDestinataire($original->getExpediteur());
    $reply->setObjet("Re: " . $original->getObjet());

    $form = $this->createForm(MessageFormType::class, $reply);
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
        return $this->redirectToRoute('CompteUtilisateur_BoiteReceptionMesssageRecus');
    }

    return $this->render('compte_utilisateur/BoiteReception/NouveauMessage.html.twig', [
        'form' => $form->createView(),
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
    public function Commande(SessionInterface $session,ProduitRepository $produitRepository,EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('acceuil_index');
        }

        // On démarre une transaction
        $conn = $em->getConnection();
        $conn->beginTransaction();

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
                    throw new \Exception("Stock insuffisant pour le produit " . $produit->getNomProduit());
                }

                // Décrémenter le stock
                $produit->setStock($produit->getStock() - $quantite);

                // Créer la ligne de commande
                $ligne = new LigneDeCommande();
                $ligne->setProduit($produit);
                $ligne->setPrixUnitaireProduit((int)$produit->getPrix()); // ⚠️ si ton prix est decimal/string, adapte le cast
                $ligne->setQuantiteCommande($quantite);
                $ligne->setCommande($commande);

                $commande->addLigneDeCommande($ligne);

                $em->persist($ligne);
            }

            // Sauvegarde commande + produits (stock mis à jour)
            $em->persist($commande);
            $em->flush();

            // Commit transaction
            $conn->commit();

            // Vider le panier
            $session->remove('panier');

            $this->addFlash('success', 'Votre commande a été validée avec succès !');

            return $this->redirectToRoute('commande_show', [
                'id' => $commande->getId(),
            ]);
        } catch (\Exception $e) {
            $conn->rollBack();
            $this->addFlash('danger', "Erreur lors de la validation : " . $e->getMessage());
            return $this->redirectToRoute('CompteUtilisateur_Panier');
        }
    }

    
    // Affiche le details de la commande
    #[Route('/commande/{id}', name: 'commande_show', requirements: ['id' => '\d+'])] // Permet de dire a symfony que la route n'accepte que des numero
    public function DetailsCommandes(Commande $commande): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Vérification que l'utilisateur connecté est bien le propriétaire de la commande
        if ($commande->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande.");
        }
        if (!$commande) {
                throw $this->createNotFoundException("Commande introuvable");
        }
        //  dd($commande);
        return $this->render('compte_utilisateur/commande/detailsCommande.html.twig', [
            'commande' => $commande,
        ]);
    }

    // afficcher l'historique
    #[Route('/commande/historique', name: 'CompteUtilisateur_HistoriqueCommande')]
    public function historiqueCommande(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupère toutes les commandes de l'utilisateur connecté
        $commandes = $em->getRepository(Commande::class)->findBy(
            ['utilisateur' => $this->getUser()],
            // ['dateCommande' => 'DESC'] // trie par date décroissante => a rajouter plus tard
        );

        return $this->render('compte_utilisateur/commande/historique.html.twig', [
            'commandes' => $commandes,
        ]);
    }

}
