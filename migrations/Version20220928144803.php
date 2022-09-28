<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928144803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indicateur ADD composant_id INT NOT NULL');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A277F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C663A277F3310E7 ON indicateur (composant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA heroku_ext');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE indicateur DROP CONSTRAINT FK_7C663A277F3310E7');
        $this->addSql('DROP INDEX IDX_7C663A277F3310E7');
        $this->addSql('ALTER TABLE indicateur DROP composant_id');
    }
}
