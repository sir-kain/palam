<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927223538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE activite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commune_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE composant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE departement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE indicateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE periodicite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE responsable_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_indicateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE activite (id INT NOT NULL, parent_id_id INT DEFAULT NULL, responsable_id INT NOT NULL, composant_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, niveau_achevement INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8755515B3750AF4 ON activite (parent_id_id)');
        $this->addSql('CREATE INDEX IDX_B875551553C59D72 ON activite (responsable_id)');
        $this->addSql('CREATE INDEX IDX_B87555157F3310E7 ON activite (composant_id)');
        $this->addSql('CREATE TABLE commune (id INT NOT NULL, departement_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E2E2D1EECCF9E01E ON commune (departement_id)');
        $this->addSql('CREATE TABLE composant (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, niveau_achevement INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE departement (id INT NOT NULL, region_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1765B6398260155 ON departement (region_id)');
        $this->addSql('CREATE TABLE indicateur (id INT NOT NULL, periodicite_id INT NOT NULL, type_indicateur_id INT NOT NULL, code VARCHAR(100) NOT NULL, libelle VARCHAR(255) NOT NULL, source VARCHAR(255) DEFAULT NULL, analyse_interpretation TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C663A272928752A ON indicateur (periodicite_id)');
        $this->addSql('CREATE INDEX IDX_7C663A27AAD63808 ON indicateur (type_indicateur_id)');
        $this->addSql('CREATE TABLE periodicite (id INT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE region (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE responsable (id INT NOT NULL, commune_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, region_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52520D07131A4F72 ON responsable (commune_id)');
        $this->addSql('CREATE INDEX IDX_52520D07CCF9E01E ON responsable (departement_id)');
        $this->addSql('CREATE INDEX IDX_52520D0798260155 ON responsable (region_id)');
        $this->addSql('CREATE TABLE type_indicateur (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES activite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551553C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555157F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A272928752A FOREIGN KEY (periodicite_id) REFERENCES periodicite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE indicateur ADD CONSTRAINT FK_7C663A27AAD63808 FOREIGN KEY (type_indicateur_id) REFERENCES type_indicateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D0798260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE activite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commune_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE composant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE departement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE indicateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE periodicite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE region_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE responsable_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_indicateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B8755515B3750AF4');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B875551553C59D72');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B87555157F3310E7');
        $this->addSql('ALTER TABLE commune DROP CONSTRAINT FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE departement DROP CONSTRAINT FK_C1765B6398260155');
        $this->addSql('ALTER TABLE indicateur DROP CONSTRAINT FK_7C663A272928752A');
        $this->addSql('ALTER TABLE indicateur DROP CONSTRAINT FK_7C663A27AAD63808');
        $this->addSql('ALTER TABLE responsable DROP CONSTRAINT FK_52520D07131A4F72');
        $this->addSql('ALTER TABLE responsable DROP CONSTRAINT FK_52520D07CCF9E01E');
        $this->addSql('ALTER TABLE responsable DROP CONSTRAINT FK_52520D0798260155');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE composant');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE indicateur');
        $this->addSql('DROP TABLE periodicite');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE type_indicateur');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
