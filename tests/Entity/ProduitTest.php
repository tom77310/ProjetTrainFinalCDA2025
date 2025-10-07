<?php

/**
 * Class ProduitTest
 *
 * Cette classe contient les tests unitaires pour l'entité Produit.
 *
 * Les tests vérifient :
 * 1. testGettersAndSetters()
 *    - que les getters et setters pour les propriétés nomProduit, description, prix et stock fonctionnent correctement
 *
 * 2. testAddAndRemoveTaille()
 *    - que la méthode addTaille() ajoute correctement une taille à la collection de tailles
 *    - que la méthode removeTaille() retire correctement une taille de la collection
 *    - utilise un mock de la classe Tailles pour tester la relation sans dépendances externes
 *
 * Remarques :
 * - Les tests sont unitaires et ne nécessitent pas de connexion à la base de données
 * - Certains IDE peuvent afficher des bugs visuels avec les mocks, mais les tests PHPUnit passent correctement
 */

namespace App\Tests\Entity;

use App\Entity\Produit;
use App\Entity\Tailles;
use PHPUnit\Framework\TestCase;

class ProduitTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $p = new Produit();
        $p->setNomProduit('Locomotive');
        $p->setDescription('Belle locomotive');
        $p->setPrix('199.99');
        $p->setStock(10);

        $this->assertSame('Locomotive', $p->getNomProduit());
        $this->assertSame('Belle locomotive', $p->getDescription());
        $this->assertSame('199.99', $p->getPrix());
        $this->assertSame(10, $p->getStock());
    }

    public function testAddAndRemoveTaille()
    {
        $p = new Produit();
        $taille = $this->createMock(Tailles::class);

        $p->addTaille($taille); // Bug visuel de VSCode (les tests passent sans erreurs)
        $this->assertTrue($p->getTailles()->contains($taille));

        $p->removeTaille($taille);
        $this->assertFalse($p->getTailles()->contains($taille));
    }
}
