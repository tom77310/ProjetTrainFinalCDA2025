<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250909120725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD expediteur_id INT DEFAULT NULL, ADD destinataire_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E9610335F61 FOREIGN KEY (expediteur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E9610335F61 ON messages (expediteur_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96A4F84F6E ON messages (destinataire_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9610335F61
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A4F84F6E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E9610335F61 ON messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E96A4F84F6E ON messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP expediteur_id, DROP destinataire_id
        SQL);
    }
}
