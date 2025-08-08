<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250808100148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE produit_commande (produit_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_47F5946EF347EFB (produit_id), INDEX IDX_47F5946E82EA2E54 (commande_id), PRIMARY KEY(produit_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produit_tailles (produit_id INT NOT NULL, tailles_id INT NOT NULL, INDEX IDX_F581AC67F347EFB (produit_id), INDEX IDX_F581AC671AEC613E (tailles_id), PRIMARY KEY(produit_id, tailles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_tailles ADD CONSTRAINT FK_F581AC67F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_tailles ADD CONSTRAINT FK_F581AC671AEC613E FOREIGN KEY (tailles_id) REFERENCES tailles (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946EF347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946E82EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_tailles DROP FOREIGN KEY FK_F581AC67F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_tailles DROP FOREIGN KEY FK_F581AC671AEC613E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit_commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit_tailles
        SQL);
    }
}
