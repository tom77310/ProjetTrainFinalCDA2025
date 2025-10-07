<?php
/**
 * Class UtilisateurTest
 *
 * Cette classe contient les tests unitaires pour l'entité Utilisateur.
 *
 * Les tests vérifient :
 * 1. testEmailAndIdentifier()
 *    - que l'email peut être défini et récupéré correctement
 *    - que la méthode getUserIdentifier() renvoie bien l'email (identifiant utilisateur)
 *
 * 2. testRolesDefault()
 *    - que les rôles définis sont correctement retournés
 *    - que le rôle par défaut "ROLE_USER" est toujours ajouté
 *    - que la liste des rôles est unique
 *
 * 3. testAddAndRemoveCommande()
 *    - que la méthode addCommande() ajoute une commande à la collection de l'utilisateur
 *    - que removeCommande() retire correctement la commande
 *    - que la méthode setUtilisateur() de la commande est appelée correctement lors de l'ajout et de la suppression
 *
 * Remarques :
 * - Ces tests portent uniquement sur le comportement de l'entité Utilisateur (tests unitaires)
 */
namespace App\Tests\Entity;

use App\Entity\Utilisateur;
use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    public function testEmailAndIdentifier()
    {
        $user = new Utilisateur();
        $user->setEmail('john.doe@example.com');

        $this->assertSame('john.doe@example.com', $user->getEmail());
        $this->assertSame('john.doe@example.com', $user->getUserIdentifier());
    }

    public function testRolesDefault()
    {
        $user = new Utilisateur();
        $user->setRoles(['ROLE_ADMIN']);

        $roles = $user->getRoles();

        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles); // rôle ajouté par défaut
        $this->assertCount(2, $roles); // ROLE_ADMIN + ROLE_USER (array_unique)
    }

    public function testAddAndRemoveCommande()
    {
        $user = new Utilisateur();

        // mock de Commande (la classe Commande doit exister dans ton projet)
        $commande = $this->createMock(Commande::class);

        // on attend deux appels à setUtilisateur : une fois avec $user (add), une fois avec null (remove)
        $commande->expects($this->exactly(2))
                 ->method('setUtilisateur')
                 ->withConsecutive([$user], [null]);

        // getUtilisateur doit renvoyer l'utilisateur pour que removeCommande fasse la remise à null
        $commande->method('getUtilisateur')->willReturn($user);

        $user->addCommande($commande); // Bug Visuel de VSCode
        $this->assertTrue($user->getCommandes()->contains($commande));

        $user->removeCommande($commande); // Bug Visuel de VSCode
        $this->assertFalse($user->getCommandes()->contains($commande));
    }
}
