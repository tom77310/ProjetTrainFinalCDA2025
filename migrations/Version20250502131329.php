<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502131329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE produit_utilisateur (produit_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_63042737F347EFB (produit_id), INDEX IDX_63042737FB88E14F (utilisateur_id), PRIMARY KEY(produit_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_utilisateur ADD CONSTRAINT FK_63042737F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_utilisateur ADD CONSTRAINT FK_63042737FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_utilisateur DROP FOREIGN KEY FK_63042737F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit_utilisateur DROP FOREIGN KEY FK_63042737FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit_utilisateur
        SQL);
    }
}
