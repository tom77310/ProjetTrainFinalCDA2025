<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502135807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD utilisateur_id INT DEFAULT NULL, ADD detailscommande_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF0DAD57C FOREIGN KEY (detailscommande_id) REFERENCES details_commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6EEAA67DFB88E14F ON commande (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6EEAA67DF0DAD57C ON commande (detailscommande_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD commande_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_29A5EC2782EA2E54 ON produit (commande_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2782EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_29A5EC2782EA2E54 ON produit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP commande_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF0DAD57C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6EEAA67DFB88E14F ON commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_6EEAA67DF0DAD57C ON commande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP utilisateur_id, DROP detailscommande_id
        SQL);
    }
}
