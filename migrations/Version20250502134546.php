<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502134546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE page_produit ADD produit_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page_produit ADD CONSTRAINT FK_D3C507B2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D3C507B2F347EFB ON page_produit (produit_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE page_produit DROP FOREIGN KEY FK_D3C507B2F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D3C507B2F347EFB ON page_produit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page_produit DROP produit_id
        SQL);
    }
}
