<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250426165311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD utilisateur_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96FB88E14F ON messages (utilisateur_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E96FB88E14F ON messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP utilisateur_id
        SQL);
    }
}
