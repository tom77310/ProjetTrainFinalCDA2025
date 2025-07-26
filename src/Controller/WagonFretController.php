<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PageProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/materiel_roulant')]
final class WagonFretController extends AbstractController
{
    #[Route('/typeWagonFret', name: 'WagonFret_typewagonfret')] // Page avec tous les type de wagons de fret
    public function PageWagonFret(CategorieRepository $WagonsFretCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('wagon_fret/WagonFret.html.twig', [
            'NomCategorie' => $WagonsFretCategorie->findBy(['id' => 4]), // Recupere le nom de la categorie
            'TypeWagonFretBache' => $PageProduit->findBy(['id' => 9]), // Recupere l'image de la table pageproduit pour l'afficher (Bache)
            'TypeWagonFretPlatRebord' => $PageProduit->findBy(['id' => 11]), // Recupere l'image de la table pageproduit pour l'afficher (PlatRebord)
            'TypeWagonsFretCouvert' => $PageProduit->findBy(['id' => 10]), // Recupere l'image de la table pageproduit pour l'afficher (Couvert)
        ]);
    }

}
