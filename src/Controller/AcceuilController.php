<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AcceuilController extends AbstractController{
    #[Route('/', name: 'acceuil_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('acceuil/index.html.twig');
    }

    // Mentions légales
    #[Route('/mentionslégales', name: 'acceuil_MentionsLegales', methods: ['GET'])]
    public function mentions(): Response
    {
        return $this->render('acceuil/mentions.html.twig');
    }

    // Conditions générales de vente 
    #[Route('/CGV', name: 'acceuil_CGV', methods: ['GET'])]
    public function CGV(): Response
    {
        return $this->render('acceuil/cgv.html.twig');
    }

    // Conditions de remboursements
    #[Route('/ConditionsRemboursements', name: 'acceuil_Conditions', methods: ['GET'])]
    public function conditions(): Response
    {
        return $this->render('acceuil/conditionsremboursements.html.twig');
    }

    // Politique de confidentialités
    #[Route('/PolitiqueConfidentialités', name: 'acceuil_PolitiqueConfidentialités', methods: ['GET'])]
    public function politiqueconfidentialite(): Response
    {
        return $this->render('acceuil/politiqueconfidentialite.html.twig');
    }

    // Paiement sécurisé
    #[Route('/PaiementSecuriser', name: 'acceuil_PaiementSecurise', methods: ['GET'])]
    public function paiementsecuriser(): Response
    {
        return $this->render('acceuil/paiementsecuriser.html.twig');
    }

    // Plus d'infos sur les trains
    #[Route('/InfosTrains', name: 'acceuil_InfosTrains', methods: ['GET'])]
    public function infostrains(): Response
    {
        return $this->render('acceuil/InfosTrains.html.twig');
    }
}
