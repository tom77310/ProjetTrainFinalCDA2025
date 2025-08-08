<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PageProduitRepository;
use App\Repository\TaillesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/materiel_roulant')]
final class TypeProduitController extends AbstractController
{
    #[Route('/typeLoco', name: 'TypeProduit_Locomotives')] // Page avec tous les type de locomotives 
    public function PageLocomotive(CategorieRepository $LocomotivesCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/locomotives.html.twig', [
            'NomCategorie' => $LocomotivesCategorie->findBy(['id' => 2]), // Recupere le nom de la categorie
            'LocoDieselG' => $TailleProduit->findBy(['id' => 1]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoDieselN' => $TailleProduit->findBy(['id' => 2]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoDieselZ' => $TailleProduit->findBy(['id' => 3]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoDieselHO' => $TailleProduit->findBy(['id' => 4]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)

            'LocoElecG' => $TailleProduit->findBy(['id' => 5]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoElecN' => $TailleProduit->findBy(['id' => 6]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoElecZ' => $TailleProduit->findBy(['id' => 7]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoElecHO' => $TailleProduit->findBy(['id' => 8]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            
            'LocoVapeurG' => $TailleProduit->findBy(['id' => 9]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoVapeurN' => $TailleProduit->findBy(['id' => 10]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoVapeurZ' => $TailleProduit->findBy(['id' => 11]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'LocoVapeurHO' => $TailleProduit->findBy(['id' => 12]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
        ]);
    }
     #[Route('/typeWagonFret', name: 'TypeProduit_WagonFret')] // Page avec tous les type de wagons de fret
    public function PageWagonFret(CategorieRepository $WagonsFretCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/WagonFret.html.twig', [
            'NomCategorie' => $WagonsFretCategorie->findBy(['id' => 4]), // Recupere le nom de la categorie
            'BacheG' => $TailleProduit->findBy(['id' => 13]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'BacheN' => $TailleProduit->findBy(['id' => 14]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'BacheZ' => $TailleProduit->findBy(['id' => 15]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'BacheHO' => $TailleProduit->findBy(['id' => 16]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)

            'CouvertG' => $TailleProduit->findBy(['id' => 17]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'CouvertN' => $TailleProduit->findBy(['id' => 18]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'CouvertZ' => $TailleProduit->findBy(['id' => 19]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'CouvertHO' => $TailleProduit->findBy(['id' => 20]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            
            'RebordG' => $TailleProduit->findBy(['id' => 21]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'RebordN' => $TailleProduit->findBy(['id' => 22]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'RebordZ' => $TailleProduit->findBy(['id' => 23]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'RebordHO' => $TailleProduit->findBy(['id' => 24]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
        ]);
    }
    // Type automotrices 
     #[Route('/typeAutomotrices', name: 'TypeProduit_Automotrices')] // Page avec tous les type de wagons de fret
    public function PageAutomotrices(CategorieRepository $AutomotriceCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/Automotrices.html.twig', [
            'NomCategorie' => $AutomotriceCategorie->findBy(['id' => 1]), // Recupere le nom de la categorie
            'AutorailsG' => $TailleProduit->findBy(['id' => 25]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'AutorailsN' => $TailleProduit->findBy(['id' => 26]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'AutorailsHO' => $TailleProduit->findBy(['id' => 27]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)

            'TGVN' => $TailleProduit->findBy(['id' => 28]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'TGVHO' => $TailleProduit->findBy(['id' => 29]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)

        ]);
    }
    // Type VoituresVoyageurs 
     #[Route('/typeVoituresVoyageurs', name: 'TypeProduit_VoituresVoyageurs')] // Page avec tous les type de Voitures de Voyageurs
    public function PageVoituresVoyageurs(CategorieRepository $VoituresVoyageursCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/VoituresVoyageurs.html.twig', [
            'NomCategorie' => $VoituresVoyageursCategorie->findBy(['id' => 3]), // Recupere le nom de la categorie
            'VVG' => $TailleProduit->findBy(['id' => 30]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'VVN' => $TailleProduit->findBy(['id' => 31]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'VVZ' => $TailleProduit->findBy(['id' => 32]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'VVHO' => $TailleProduit->findBy(['id' => 33]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
        ]);
    }

    // Type Infrastructures Ferroviaires
     #[Route('/typeInfra', name: 'TypeProduit_Infrastructures')] // Page avec tous les type de infra
    public function PageInfra(CategorieRepository $InfraCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/Infra.html.twig', [
            'NomCategorie' => $InfraCategorie->findBy(['id' => 5]), // Recupere le nom de la categorie
            'PontsG' => $TailleProduit->findBy(['id' => 34]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'PontsZ' => $TailleProduit->findBy(['id' => 35]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'PontsHO' => $TailleProduit->findBy(['id' => 36]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)

            'TunnelHO1' => $TailleProduit->findBy(['id' => 37]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'TunnelHO2' => $TailleProduit->findBy(['id' => 38]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'TunnelN' => $TailleProduit->findBy(['id' => 39]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)

            'SignaHO' => $TailleProduit->findBy(['id' => 40]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'SignaN' => $TailleProduit->findBy(['id' => 41]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
           
        ]);
    }

    // Type Voies ferroviaires
     #[Route('/typeVoies', name: 'TypeProduit_Voies')] // Page avec tous les type de infra
    public function PageVoies(CategorieRepository $VoiesCategorie, TaillesRepository $TailleProduit): Response
    {
        return $this->render('TypeProduits/Voies.html.twig', [
            'NomCategorie' => $VoiesCategorie->findBy(['id' => 6]), // Recupere le nom de la categorie
            'VoiesG' => $TailleProduit->findBy(['id' => 42]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'VoiesZ' => $TailleProduit->findBy(['id' => 43]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'VoiesHO' => $TailleProduit->findBy(['id' => 44]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
            'VoiesN' => $TailleProduit->findBy(['id' => 45]), // Recupere l'image de la table pageproduit pour l'afficher (Ponts)
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
