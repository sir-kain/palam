<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919190617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD composant_id INT NOT NULL');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555157F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id)');
        $this->addSql('CREATE INDEX IDX_B87555157F3310E7 ON activite (composant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555157F3310E7');
        $this->addSql('DROP INDEX IDX_B87555157F3310E7 ON activite');
        $this->addSql('ALTER TABLE activite DROP composant_id');
    }
}
