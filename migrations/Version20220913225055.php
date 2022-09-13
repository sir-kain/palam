<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913225055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, parent_id_id INT DEFAULT NULL, responsable_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, niveau_achevement VARCHAR(255) NOT NULL, INDEX IDX_B8755515B3750AF4 (parent_id_id), INDEX IDX_B875551553C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composant (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indicateur (id INT AUTO_INCREMENT NOT NULL, periodicite_id INT NOT NULL, type_indicateur_id INT NOT NULL, code VARCHAR(100) NOT NULL, libelle VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, analyse_interpretation LONGTEXT NOT NULL, INDEX IDX_7C663A272928752A (periodicite_id), INDEX IDX_7C663A27AAD63808 (type_indicateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodicite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, commune_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, region_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_52520D07131A4F72 (commune_id), INDEX IDX_52520D07CCF9E01E (departement_id), INDEX IDX_52520D0798260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_indicateur (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551553C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A272928752A FOREIGN KEY (periodicite_id) REFERENCES periodicite (id)');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A27AAD63808 FOREIGN KEY (type_indicateur_id) REFERENCES type_indicateur (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D0798260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515B3750AF4');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551553C59D72');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE indicateur DROP FOREIGN KEY FK_7C663A272928752A');
        $this->addSql('ALTER TABLE indicateur DROP FOREIGN KEY FK_7C663A27AAD63808');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07131A4F72');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07CCF9E01E');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D0798260155');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE composant');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE indicateur');
        $this->addSql('DROP TABLE periodicite');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE type_indicateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
