<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MaterielRoulantController extends AbstractController
{
    #[Route('/materiel_roulant', name: 'MaterielRoulant_matRoulant')]
    public function PageMaterielRoulants(CategorieRepository $MaterielRoulantsCategorie): Response
    {
        return $this->render('materiel_roulant/matRoulants.html.twig', [
            'MaterielRoulant' => $MaterielRoulantsCategorie->findBy(['id' => 7]), // Page materiel roulants => récuperer les images pour la page
        ]);
    }
    

}
