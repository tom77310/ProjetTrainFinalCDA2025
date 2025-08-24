<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824170744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE produit_taille (produit_id INT NOT NULL, tailles_id INT NOT NULL, INDEX IDX_81024002F347EFB (produit_id), INDEX IDX_810240021AEC613E (tailles_id), PRIMARY KEY(produit_id, tailles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_taille ADD CONSTRAINT FK_81024002F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_taille ADD CONSTRAINT FK_810240021AEC613E FOREIGN KEY (tailles_id) REFERENCES tailles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP ligne_de_commande_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE68BF5C2E6
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7982ACE68BF5C2E6 ON ligne_de_commande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande ADD quantite_commande INT NOT NULL, ADD prix_unitaire_produit INT NOT NULL, DROP quantitecommande, DROP prixunitaireproduit, CHANGE commandes_id commande_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande (commande_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD categorie_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD stock INT DEFAULT NULL, DROP nom_produit, DROP quantite, DROP detail, DROP vue1, DROP vue2, DROP vue3, CHANGE prix prix NUMERIC(10, 2) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles CHANGE libeles_tailles libelle_taille VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_taille DROP FOREIGN KEY FK_81024002F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_taille DROP FOREIGN KEY FK_810240021AEC613E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit_taille
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles CHANGE libelle_taille libeles_tailles VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD ligne_de_commande_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_29A5EC27BCF5E72D ON produit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD quantite VARCHAR(255) NOT NULL, ADD detail LONGTEXT NOT NULL, ADD vue1 VARCHAR(255) NOT NULL, ADD vue2 VARCHAR(255) NOT NULL, ADD vue3 VARCHAR(255) NOT NULL, DROP categorie_id, DROP description, DROP stock, CHANGE prix prix INT NOT NULL, CHANGE nom nom_produit VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE682EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande ADD quantitecommande INT NOT NULL, ADD prixunitaireproduit INT NOT NULL, DROP quantite_commande, DROP prix_unitaire_produit, CHANGE commande_id commandes_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE68BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7982ACE68BF5C2E6 ON ligne_de_commande (commandes_id)
        SQL);
    }
}
