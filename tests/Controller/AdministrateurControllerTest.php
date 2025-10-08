<?php

namespace App\Tests\Controller;

use App\Entity\Utilisateur;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdministrateurControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

   /* =====================================================
   TESTS Administrateur gestion des utilisateurs (Découpés)
   ======================================================== */

public function testAccesListeUtilisateurs()
{
    // Test : Vérifier que la page liste des utilisateurs est accessible
    $crawler = $this->client->request('GET', '/compte/administrateur/ListeUtilisateurs');
    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Liste des Utilisateurs');
}

public function testAjoutUtilisateurAvecErreur()
{
    // Test : Soumettre le formulaire d'ajout utilisateur avec email vide
    $crawler = $this->client->request('GET', '/compte/administrateur/Ajoututilisateur');
    $this->assertResponseIsSuccessful();

    $form = $crawler->selectButton('Ajouter')->form();
    $form['ajout_utilisateur_form[email]'] = '';
    $form['ajout_utilisateur_form[nom]'] = 'Dupont';
    $form['ajout_utilisateur_form[prenom]'] = 'Jean';
    $form['ajout_utilisateur_form[adresse]'] = '1 rue de Paris';
    $form['ajout_utilisateur_form[telephone]'] = '0123456789';
    $form['ajout_utilisateur_form[date_naissance]'] = '2000-01-01';
    $form['ajout_utilisateur_form[password]'] = 'Password1';
    $form['ajout_utilisateur_form[roles]'] = ['ROLE_USER'];

    $crawler = $this->client->submit($form);

    // Vérification : le formulaire doit afficher une erreur
    $this->assertSelectorTextContains('body', 'L\'email est obligatoire.');
}

public function testAjoutUtilisateurCorrect(): void
{
    // On charge la page du formulaire
    $crawler = $this->client->request('GET', '/compte/administrateur/Ajoututilisateur');

    // Vérifie que la page est bien accessible
    $this->assertResponseIsSuccessful();

    // Récupère le formulaire
    $form = $crawler->filter('form')->form();

    // Remplissage complet du formulaire
    $form['ajout_utilisateur_form[civilite]'] = 'Madame';
    $form['ajout_utilisateur_form[nom]'] = 'Duponde';
    $form['ajout_utilisateur_form[prenom]'] = 'Jeannette';
    $form['ajout_utilisateur_form[date_naissance]'] = '2000-01-01';
    $form['ajout_utilisateur_form[adresse]'] = '1 rue de Paris';
    $form['ajout_utilisateur_form[cp]'] = '75001';
    $form['ajout_utilisateur_form[ville]'] = 'Paris';
    $form['ajout_utilisateur_form[telephone]'] = '0123456789';
    $form['ajout_utilisateur_form[email]'] = 'testuser@example.com';
    $form['ajout_utilisateur_form[login]'] = 'testuser';
    $form['ajout_utilisateur_form[password]'] = 'Tlemaire03022002'; // conforme aux règles
    $form['ajout_utilisateur_form[roles]'] = 'ROLE_USER';

    // Envoi du formulaire
    $this->client->submit($form);

    // Vérifie la redirection vers la liste
    $this->assertResponseRedirects('/compte/administrateur/ListeUtilisateurs');

    // Suit la redirection
    $this->client->followRedirect();

    // Vérifie que l’utilisateur est bien présent
    $this->assertSelectorTextContains('td div[data-test-email]', 'testuser@example.com');
}

public function testModificationUtilisateur()
{
    // Récupère la page de la liste des utilisateurs
    $crawler = $this->client->request('GET', '/compte/administrateur/ListeUtilisateurs');

    // Clique sur le premier lien "Modifier"
    $link = $crawler->filter('a[data-test-modifier]')->first()->link();
    $crawler = $this->client->click($link);


    // Récupère le formulaire par son nom
    $form = $crawler->filter('form[name="modif_utilisateur_form"]')->form();

    // Remplit les champs
    $form['modif_utilisateur_form[Nom]'] = 'Dupont';

    // Soumet le formulaire
    $this->client->submit($form);

    // Vérifie la redirection
    $this->assertResponseRedirects('/compte/administrateur/ListeUtilisateurs');
    $this->client->followRedirect();

    // Vérifie que le nom a bien été modifié
    $this->assertSelectorTextContains('td div[data-test-nom]', 'Dupont');
}


public function testDetailUtilisateur()
{
    // Test : Afficher le détail du premier utilisateur
    $crawler = $this->client->request('GET', '/compte/administrateur/ListeUtilisateurs');
    $link = $crawler->filter('a:contains("Details")')->first()->link();
    $crawler = $this->client->click($link);

    // Vérification : page détail accessible et affichage du titre
    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Détail de l\'utilisateur sélectionné');
}

public function testSuppressionUtilisateur()
{
    // Test : Supprimer le premier utilisateur de la liste
    // On va sur la liste des utilisateurs
    $crawler = $this->client->request('GET', '/compte/administrateur/ListeUtilisateurs');

    //  On va chercher le lien "Details" du premier utilisateur
    $linkNode = $crawler->filter('a')->reduce(function ($node) {
        return trim($node->text()) === 'Details';
    })->first();

    $this->assertNotNull($linkNode, 'Le lien "Details" doit exister');

    $crawler = $this->client->click($linkNode->link());

    // On va vérifier que le formulaire de suppression est bien présent
    $this->assertGreaterThan(0, $crawler->filter('div.Supprimer form')->count(), 'Le formulaire de suppression doit être présent');

    // On soumet le formulaire
    $form = $crawler->filter('div.Supprimer form')->first()->form();
    $this->client->submit($form);

    // On va vérifier la redirection
    $this->assertResponseRedirects('/compte/administrateur/ListeUtilisateurs');

    // Et enfin on va suivre la redirection
    $crawler = $this->client->followRedirect();
    $this->assertSelectorNotExists('td div[data-test-email]', 'L\'utilisateur supprimé ne doit plus apparaître');
}

}
