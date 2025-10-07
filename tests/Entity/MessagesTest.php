<?php
/**
 * Class MessagesTest
 *
 * Cette classe contient les tests unitaires pour l'entité Messages.
 *
 * Les tests vérifient :
 * 1. testGettersAndSetters()
 *    - que les getters et setters pour les propriétés objet, description et piece_jointe fonctionnent correctement
 *
 * 2. testExpediteurDestinataire()
 *    - que la méthode setExpediteur() associe correctement un utilisateur en tant qu'expéditeur
 *    - que la méthode setDestinataire() associe correctement un utilisateur en tant que destinataire
 *    - que les getters renvoient bien les objets utilisateur associés
 *
 * Remarques :
 * - Ces tests sont unitaires et ne nécessitent pas de connexion à la base de données
 */

namespace App\Tests\Entity;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $m = new Messages();
        $m->setObjet('Sujet');
        $m->setDescription('Contenu du message');
        $m->setPieceJointe('file.pdf');

        $this->assertSame('Sujet', $m->getObjet());
        $this->assertSame('Contenu du message', $m->getDescription());
        $this->assertSame('file.pdf', $m->getPieceJointe());
    }

    public function testExpediteurDestinataire()
    {
        $m = new Messages();
        $user = new Utilisateur();

        $m->setExpediteur($user);
        $m->setDestinataire($user);

        $this->assertSame($user, $m->getExpediteur());
        $this->assertSame($user, $m->getDestinataire());
    }
}
