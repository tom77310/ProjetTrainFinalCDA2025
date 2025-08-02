<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PageProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/materiel_roulant')]
final class TypeProduitController extends AbstractController
{
    #[Route('/typeLoco', name: 'TypeProduit_Locomotives')] // Page avec tous les type de locomotives 
    public function PageLocomotive(CategorieRepository $LocomotivesCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/locomotives.html.twig', [
            'NomCategorie' => $LocomotivesCategorie->findBy(['id' => 2]), // Recupere le nom de la categorie
            'TypeLocoDiesel' => $PageProduit->findBy(['id' => 2]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'TypeLocoElec' => $PageProduit->findBy(['id' => 3]), // Recupere l'image de la table pageproduit pour l'afficher (Elec)
            'TypeLocoVapeur' => $PageProduit->findBy(['id' => 4]), // Recupere l'image de la table pageproduit pour l'afficher (Vapeur)
        ]);
    }
     #[Route('/typeWagonFret', name: 'TypeProduit_WagonFret')] // Page avec tous les type de wagons de fret
    public function PageWagonFret(CategorieRepository $WagonsFretCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/WagonFret.html.twig', [
            'NomCategorie' => $WagonsFretCategorie->findBy(['id' => 4]), // Recupere le nom de la categorie
            'TypeWagonFretBache' => $PageProduit->findBy(['id' => 9]), // Recupere l'image de la table pageproduit pour l'afficher (Bache)
            'TypeWagonFretPlatRebord' => $PageProduit->findBy(['id' => 11]), // Recupere l'image de la table pageproduit pour l'afficher (PlatRebord)
            'TypeWagonsFretCouvert' => $PageProduit->findBy(['id' => 10]), // Recupere l'image de la table pageproduit pour l'afficher (Couvert)
        ]);
    }
    // Type automotrices 
     #[Route('/typeAutomotrices', name: 'TypeProduit_Automotrices')] // Page avec tous les type de wagons de fret
    public function PageAutomotrices(CategorieRepository $AutomotriceCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/Automotrices.html.twig', [
            'NomCategorie' => $AutomotriceCategorie->findBy(['id' => 1]), // Recupere le nom de la categorie
            'Autorails' => $PageProduit->findBy(['id' => 1]), // Recupere l'image de la table pageproduit pour l'afficher (Autorails)
            'TGV' => $PageProduit->findBy(['id' => 6]), // Recupere l'image de la table pageproduit pour l'afficher (TGV)
        ]);
    }
    // Type VoituresVoyageurs 
     #[Route('/typeVoituresVoyageurs', name: 'TypeProduit_VoituresVoyageurs')] // Page avec tous les type de Voitures de Voyageurs
    public function PageVoituresVoyageurs(CategorieRepository $VoituresVoyageursCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/VoituresVoyageurs.html.twig', [
            'NomCategorie' => $VoituresVoyageursCategorie->findBy(['id' => 3]), // Recupere le nom de la categorie
            'VoituresVoyageurs' => $PageProduit->findBy(['id' => 8]), // Recupere l'image de la table pageproduit pour l'afficher (Autorails)
        ]);
    }

    // Type Infrastructures Ferroviaires
     #[Route('/typeInfra', name: 'TypeProduit_Infrastructures')] // Page avec tous les type de infra
    public function PageInfra(CategorieRepository $InfraCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/Infra.html.twig', [
            'NomCategorie' => $InfraCategorie->findBy(['id' => 5]), // Recupere le nom de la categorie
            'Ponts' => $PageProduit->findBy(['id' => 12]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'Signalisation' => $PageProduit->findBy(['id' => 13]), // Recupere l'image de la table pageproduit pour l'afficher (Signa)
            'Tunnel' => $PageProduit->findBy(['id' => 5]), // Recupere l'image de la table pageproduit pour l'afficher (Tunnels)
        ]);
    }

    // Type Voies ferroviaires
     #[Route('/typeVoies', name: 'TypeProduit_Voies')] // Page avec tous les type de infra
    public function PageVoies(CategorieRepository $VoiesCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('TypeProduits/Voies.html.twig', [
            'NomCategorie' => $VoiesCategorie->findBy(['id' => 6]), // Recupere le nom de la categorie
            'Voies' => $PageProduit->findBy(['id' => 7]), // Recupere l'image de la table pageproduit pour l'afficher (Voies)
        ]);
    }

    // Tailles existantes
     #[Route('/taillesExistantes', name: 'TypeProduit_TaillesExistantes')] // Page avec tous les type de infra
    public function PageTailles(): Response
    {
        return $this->render('TypeProduits/TaillesExistantes.html.twig',[
            'controller_name' => 'TypeProduitController', // Je n'ai pas besoin de récuperer des données de la BDD, juste la page qui correspond
        ]); 
    }

}
