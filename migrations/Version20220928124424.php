<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928124424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indicateur ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A2753C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C663A2753C59D72 ON indicateur (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA heroku_ext');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE indicateur DROP CONSTRAINT FK_7C663A2753C59D72');
        $this->addSql('DROP INDEX IDX_7C663A2753C59D72');
        $this->addSql('ALTER TABLE indicateur DROP responsable_id');
    }
}
