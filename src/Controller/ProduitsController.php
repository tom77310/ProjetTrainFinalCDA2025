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
    //Diesel
    // Produits Loco Diesel Taille G
    #[Route('/locoDieselG', name: 'produits_dieselG')]
    public function LocoDieselG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Diesel/DieselG.html.twig', [
            'LocoDieselG' => $Produitrepository->findBy(['id' => 41]),
        ]);
    }
    // Produits Loco Diesel Taille N
    #[Route('/locoDieselN', name: 'produits_dieselN')]
    public function LocoDieselN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Diesel/DieselN.html.twig', [
            'LocoDieselN' => $Produitrepository->findBy(['id' => 40]),
        ]);
    }
    // Produits Loco Diesel Taille Z
    #[Route('/locoDieselZ', name: 'produits_dieselZ')]
    public function LocoDieselZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Diesel/DieselZ.html.twig', [
            'LocoDieselZ' => $Produitrepository->findBy(['id' => 39]),
        ]);
    }
    // Produits Loco Diesel Taille HO
    #[Route('/locoDieselHO', name: 'produits_dieselHO')]
    public function LocoDieselHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Diesel/DieselHO.html.twig', [
            'LocoDieselHO' => $Produitrepository->findBy(['id' => 38]),
        ]);
    }

    // Elec
    // Produits Loco Elec Taille G
    #[Route('/ElecG', name: 'produits_ElecG')]
    public function LocoElecG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Elec/ElecG.html.twig', [
            'LocoElecG' => $Produitrepository->findBy(['id' => 37]),
        ]);
    }
    // Produits Loco Elec Taille N
    #[Route('/locoElecN', name: 'produits_ElecN')]
    public function LocoElecN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Elec/ElecN.html.twig', [
            'LocoElecN' => $Produitrepository->findBy(['id' => 36]),
        ]);
    }
    // Produits Loco Elec Taille Z
    #[Route('/locoElecZ', name: 'produits_ElecZ')]
    public function LocoElecZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Elec/ElecZ.html.twig', [
            'LocoElecZ' => $Produitrepository->findBy(['id' => 35]),
        ]);
    }
    // Produits Loco Elec Taille HO
    #[Route('/locoElecHO', name: 'produits_ElecHO')]
    public function LocoElecHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Elec/ElecHO.html.twig', [
            'LocoElecHO' => $Produitrepository->findBy(['id' => 34]),
        ]);
    }
    // Elec
    // Produits Loco Vapeur Taille G
    #[Route('/VapeurG', name: 'produits_VapeurG')]
    public function LocoVapeurG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Vapeur/VapeurG.html.twig', [
            'LocoVapeurG' => $Produitrepository->findBy(['id' => 45]),
        ]);
    }
    // Produits Loco Vapeur Taille N
    #[Route('/locoVapeurN', name: 'produits_VapeurN')]
    public function LocoVapeurN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Vapeur/VapeurN.html.twig', [
            'LocoVapeurN' => $Produitrepository->findBy(['id' => 44]),
        ]);
    }
    // Produits Loco Vapeur Taille Z
    #[Route('/locoVapeurZ', name: 'produits_VapeurZ')]
    public function LocoVapeurZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Vapeur/VapeurZ.html.twig', [
            'LocoVapeurZ' => $Produitrepository->findBy(['id' => 43]),
        ]);
    }
    // Produits Loco Vapeur Taille HO
    #[Route('/locoVapeurHO', name: 'produits_VapeurHO')]
    public function LocoVapeurHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Locos/Vapeur/VapeurHO.html.twig', [
            'LocoVapeurHO' => $Produitrepository->findBy(['id' => 42]),
        ]);
    }
}
