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
}
