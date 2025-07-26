<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PageProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/materiel_roulant')]
final class LocomotivesController extends AbstractController
{
    #[Route('/typeLoco', name: 'Locomotives_typelocos')] // Page avec tous les type de locomotives 
    public function PageLocomotive(CategorieRepository $LocomotivesCategorie, PageProduitRepository $PageProduit): Response
    {
        return $this->render('locomotives/locomotives.html.twig', [
            'NomCategorie' => $LocomotivesCategorie->findBy(['id' => 2]), // Recupere le nom de la categorie
            'TypeLocoDiesel' => $PageProduit->findBy(['id' => 2]), // Recupere l'image de la table pageproduit pour l'afficher (locodiesel)
            'TypeLocoElec' => $PageProduit->findBy(['id' => 3]), // Recupere l'image de la table pageproduit pour l'afficher (Elec)
            'TypeLocoVapeur' => $PageProduit->findBy(['id' => 4]), // Recupere l'image de la table pageproduit pour l'afficher (Vapeur)
        ]);
    }

}
