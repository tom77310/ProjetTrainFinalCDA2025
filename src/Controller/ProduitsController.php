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

    // Wagons de fret
    // Bache
    // Produits Wagons de fret Bache Taille G
    #[Route('/WFBacheG', name: 'produits_bacheG')]
    public function WFBacheG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Bache/WFBacheG.html.twig', [
            'WFBacheG' => $Produitrepository->findBy(['id' => 49]),
        ]);
    }
    // Produits Wagons de fret Bache Taille N
    #[Route('/WFBacheN', name: 'produits_bacheN')]
    public function WFBacheN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Bache/WFBacheN.html.twig', [
            'WFBacheN' => $Produitrepository->findBy(['id' => 48]),
        ]);
    }
    // Produits Wagons de Fret Bache Taille Z
    #[Route('/WFBacheZ', name: 'produits_bacheZ')]
    public function WFBacheZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Bache/WFBacheZ.html.twig', [
            'WFBacheZ' => $Produitrepository->findBy(['id' => 47]),
        ]);
    }
    // Produits Wagons de fret bache Taille HO
    #[Route('/WFBacheHO', name: 'produits_bacheHO')]
    public function WFBacheHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Bache/WFBacheHO.html.twig', [
            'WFBacheHO' => $Produitrepository->findBy(['id' => 46]),
        ]);
    }

    // Couvert
    // Produits Wagons de fret Couvert Taille G
    #[Route('/WFCouvertG', name: 'produits_couvertG')]
    public function WFCouvertG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Couvert/WFCouvertG.html.twig', [
            'WFCouvertG' => $Produitrepository->findBy(['id' => 57]),
        ]);
    }
    // Produits Wagons de fret Couvert Taille N
    #[Route('/WFCouvertN', name: 'produits_couvertN')]
    public function WFCouvertN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Couvert/WFCouvertN.html.twig', [
            'WFCouvertN' => $Produitrepository->findBy(['id' => 56]),
        ]);
    }
    // Produits Wagons de Fret Couvert Taille Z
    #[Route('/WFCouvertZ', name: 'produits_couvertZ')]
    public function WFCouvertZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Couvert/WFCouvertZ.html.twig', [
            'WFCouvertZ' => $Produitrepository->findBy(['id' => 55]),
        ]);
    }
    // Produits Wagons de Fret Couvert Taille HO
    #[Route('/WFCouvertHO', name: 'produits_couvertHO')]
    public function WFCouvertHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Couvert/WFCouvertHO.html.twig', [
            'WFCouvertHO' => $Produitrepository->findBy(['id' => 54]),
        ]);
    }

    // Plat à Rebord
    // Produits Wagons de fret Rebord Taille G
    #[Route('/WFRebordG', name: 'produits_rebordG')]
    public function WFRebordG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Rebord/WFRebordG.html.twig', [
            'WFRebordG' => $Produitrepository->findBy(['id' => 53]),
        ]);
    }
    // Produits Wagons de fret Rebord Taille N
    #[Route('/WFRebordN', name: 'produits_rebordN')]
    public function WFRebordN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Rebord/WFRebordN.html.twig', [
            'WFRebordN' => $Produitrepository->findBy(['id' => 52]),
        ]);
    }
    // Produits Wagons de Fret Rebord Taille Z
    #[Route('/WFRebordZ', name: 'produits_rebordZ')]
    public function WFRebordZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Rebord/WFRebordZ.html.twig', [
            'WFRebordZ' => $Produitrepository->findBy(['id' => 51]),
        ]);
    }
    // Produits Wagon de Fret Rebord Taille HO
    #[Route('/WFRebordHO', name: 'produits_rebordHO')]
    public function WFRebordHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/WagonsFret/Rebord/WFRebordHO.html.twig', [
            'WFRebordHO' => $Produitrepository->findBy(['id' => 50]),
        ]);
    }

    // Produits Automotrices
    // Autorails Taille HO
    #[Route('/AutorailsHO', name: 'produits_autorailsHO')]
    public function AutorailsHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Automotrices/Autorails/AutorailsHO.html.twig', [
            'AutorailsHO' => $Produitrepository->findBy(['id' => 1]),
        ]);
    }
    // Autorails Taille G
    #[Route('/AutorailsG', name: 'produits_autorailsG')]
    public function AutorailsG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Automotrices/Autorails/AutorailsG.html.twig', [
            'AutorailsG' => $Produitrepository->findBy(['id' => 3]),
        ]);
    }
    // Autorails Taille N
    #[Route('/AutorailsN', name: 'produits_autorailsN')]
    public function AutorailsN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Automotrices/Autorails/AutorailsN.html.twig', [
            'AutorailsN' => $Produitrepository->findBy(['id' => 2]),
        ]);
    }
     // TGV Taille HO
    #[Route('/TGVHO', name: 'produits_TGVHO')]
    public function TGVHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Automotrices/TGV/TGVHO.html.twig', [
            'TGVHO' => $Produitrepository->findBy(['id' => 4]),
        ]);
    }
    // TGV Taille N
    #[Route('/TGVN', name: 'produits_TGVN')]
    public function TGVN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Automotrices/TGV/TGVN.html.twig', [
            'TGVN' => $Produitrepository->findBy(['id' => 5]),
        ]);
    }
    // VoituresVoyageurs
    // Taille HO
    #[Route('/VoituresVoyageursHO', name: 'produits_VoituresVoyageursHO')]
    public function VoituresVoyageursHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/VoituresVoyageurs/VoituresVoyageursHO.html.twig', [
            'VoituresVoyageursHO' => $Produitrepository->findBy(['id' => 6]),
        ]);
    }
    // Taille Z
    #[Route('/VoituresVoyageursZ', name: 'produits_VoituresVoyageursZ')]
    public function VoituresVoyageursZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/VoituresVoyageurs/VoituresVoyageursZ.html.twig', [
            'VoituresVoyageursZ' => $Produitrepository->findBy(['id' => 7]),
        ]);
    }
    // Taille N
    #[Route('/VoituresVoyageursN', name: 'produits_VoituresVoyageursN')]
    public function VoituresVoyageursN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/VoituresVoyageurs/VoituresVoyageursN.html.twig', [
            'VoituresVoyageursN' => $Produitrepository->findBy(['id' => 8]),
        ]);
    }
    // Taille G
    #[Route('/VoituresVoyageursG', name: 'produits_VoituresVoyageursG')]
    public function VoituresVoyageursG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/VoituresVoyageurs/VoituresVoyageursG.html.twig', [
            'VoituresVoyageursG' => $Produitrepository->findBy(['id' => 9]),
        ]);
    }

    // Infra
    // Ponts
    // Taille HO
    #[Route('/PontsHO', name: 'produits_PontsHO')]
    public function PontsHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Ponts/PontsHO.html.twig', [
            'PontsHO' => $Produitrepository->findBy(['id' => 65]),
        ]);
    }
    
    // Taille Z
    #[Route('/PontsZ', name: 'produits_PontsZ')]
    public function PontsZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Ponts/PontsZ.html.twig', [
            'PontsZ' => $Produitrepository->findBy(['id' => 66]),
        ]);
    }

    // Taille G
    #[Route('/PontsG', name: 'produits_PontsG')]
    public function PontsG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Ponts/PontsG.html.twig', [
            'PontsG' => $Produitrepository->findBy(['id' => 67]),
        ]);
    }
    // Tunnels
    // Taille HO 1
    #[Route('/TunnelHO1', name: 'produits_TunnelHO1')]
    public function TunnelHO1(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Tunnels/TunnelHO1.html.twig', [
            'TunnelHO1' => $Produitrepository->findBy(['id' => 62]),
        ]);
    }
    // Taille HO 2
    #[Route('/TunnelHO2', name: 'produits_TunnelHO2')]
    public function TunnelHO2(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Tunnels/TunnelHO2.html.twig', [
            'TunnelHO2' => $Produitrepository->findBy(['id' => 63]),
        ]);
    }
    // Taille N
    #[Route('/TunnelN', name: 'produits_TunnelN')]
    public function TunnelN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Tunnels/TunnelN.html.twig', [
            'TunnelN' => $Produitrepository->findBy(['id' => 64]),
        ]);
    }
    // Signalisation
    // Signa HO
    #[Route('/SignaHO', name: 'produits_SignaHO')]
    public function SignaHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Signa/SignaHO.html.twig', [
            'SignaHO' => $Produitrepository->findBy(['id' => 68]),
        ]);
    }
    // Signa N
    #[Route('/SignaN', name: 'produits_SignaN')]
    public function SignaN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Infra/Signa/SignaN.html.twig', [
            'SignaN' => $Produitrepository->findBy(['id' => 69]),
        ]);
    }
    // Voies
    // Voies HO
    #[Route('/VoiesHO', name: 'produits_voiesHO')]
    public function VoiesHO(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Voies/VoiesHO.html.twig', [
            'VoiesHO' => $Produitrepository->findBy(['id' => 58]),
        ]);
    }
    // Voies Z
    #[Route('/VoiesZ', name: 'produits_voiesZ')]
    public function VoiesZ(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Voies/VoiesZ.html.twig', [
            'VoiesZ' => $Produitrepository->findBy(['id' => 59]),
        ]);
    }
    // Voies N
    #[Route('/VoiesN', name: 'produits_voiesN')]
    public function VoiesN(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Voies/VoiesN.html.twig', [
            'VoiesN' => $Produitrepository->findBy(['id' => 60]),
        ]);
    }
    
    // Voies G
    #[Route('/VoiesG', name: 'produits_voiesG')]
    public function VoiesG(ProduitRepository $Produitrepository): Response
    {
        return $this->render('produits/Voies/VoiesG.html.twig', [
            'VoiesG' => $Produitrepository->findBy(['id' => 61]),
        ]);
    }
    
}
