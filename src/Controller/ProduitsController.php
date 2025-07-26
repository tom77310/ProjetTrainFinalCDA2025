<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produits')]
final class ProduitsController extends AbstractController
{
    // concerne toutes les pages produits apres avoir cliquer sur exemple : loco diesel ho, on se retrouve sur la page produit
    #[Route('/locoDieselG', name: 'app_produits')]
    public function index(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/DieselG.html.twig', [
            'LocoDieselG' => $Produitrepository->findBy(['id' => 41]),
        ]);
    }
}
