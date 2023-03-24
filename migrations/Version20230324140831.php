<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324140831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE equipement_sportif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE main_oeuvre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manifestation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manifestation_equipement_sportif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manifestation_main_oeuvre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manifestation_materiel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manifestation_transport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE materiel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE organisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE equipement_sportif (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix_horaire DOUBLE PRECISION NOT NULL, code_planitec VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE main_oeuvre (id INT NOT NULL, categorie VARCHAR(255) NOT NULL, prix_horaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE manifestation (id INT NOT NULL, organisateur_id INT NOT NULL, denomination VARCHAR(255) NOT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, lieu VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F2B3F7FD936B2FA ON manifestation (organisateur_id)');
        $this->addSql('CREATE TABLE manifestation_equipement_sportif (id INT NOT NULL, manifestation_id INT NOT NULL, equipement_sportif_id INT NOT NULL, heure INT NOT NULL, prix_horaire_fact DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EB8EF275CD8E394E ON manifestation_equipement_sportif (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_EB8EF275E9E7DB4B ON manifestation_equipement_sportif (equipement_sportif_id)');
        $this->addSql('CREATE TABLE manifestation_main_oeuvre (id INT NOT NULL, manifestation_id INT NOT NULL, main_oeuvre_id INT NOT NULL, heure INT NOT NULL, prix_horaire_fact DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D74331BCD8E394E ON manifestation_main_oeuvre (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_2D74331BA8AFEA4A ON manifestation_main_oeuvre (main_oeuvre_id)');
        $this->addSql('CREATE TABLE manifestation_materiel (id INT NOT NULL, manifestation_id INT NOT NULL, materiel_id INT NOT NULL, jour INT DEFAULT NULL, qte INT NOT NULL, prix_unitaire_fact DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_71FD68CDCD8E394E ON manifestation_materiel (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_71FD68CD16880AAF ON manifestation_materiel (materiel_id)');
        $this->addSql('CREATE TABLE manifestation_transport (id INT NOT NULL, manifestation_id INT NOT NULL, transport_id INT NOT NULL, heure INT NOT NULL, prix_horaire_fact DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41F1329CD8E394E ON manifestation_transport (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_41F13299909C13F ON manifestation_transport (transport_id)');
        $this->addSql('CREATE TABLE materiel (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, est_par_jour BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE organisateur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, service_demandeur VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transport (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix_horaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7FD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_equipement_sportif ADD CONSTRAINT FK_EB8EF275CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_equipement_sportif ADD CONSTRAINT FK_EB8EF275E9E7DB4B FOREIGN KEY (equipement_sportif_id) REFERENCES equipement_sportif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_main_oeuvre ADD CONSTRAINT FK_2D74331BCD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_main_oeuvre ADD CONSTRAINT FK_2D74331BA8AFEA4A FOREIGN KEY (main_oeuvre_id) REFERENCES main_oeuvre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_materiel ADD CONSTRAINT FK_71FD68CDCD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_materiel ADD CONSTRAINT FK_71FD68CD16880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_transport ADD CONSTRAINT FK_41F1329CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_transport ADD CONSTRAINT FK_41F13299909C13F FOREIGN KEY (transport_id) REFERENCES transport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE equipement_sportif_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE main_oeuvre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manifestation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manifestation_equipement_sportif_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manifestation_main_oeuvre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manifestation_materiel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manifestation_transport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE materiel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE organisateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transport_id_seq CASCADE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7FD936B2FA');
        $this->addSql('ALTER TABLE manifestation_equipement_sportif DROP CONSTRAINT FK_EB8EF275CD8E394E');
        $this->addSql('ALTER TABLE manifestation_equipement_sportif DROP CONSTRAINT FK_EB8EF275E9E7DB4B');
        $this->addSql('ALTER TABLE manifestation_main_oeuvre DROP CONSTRAINT FK_2D74331BCD8E394E');
        $this->addSql('ALTER TABLE manifestation_main_oeuvre DROP CONSTRAINT FK_2D74331BA8AFEA4A');
        $this->addSql('ALTER TABLE manifestation_materiel DROP CONSTRAINT FK_71FD68CDCD8E394E');
        $this->addSql('ALTER TABLE manifestation_materiel DROP CONSTRAINT FK_71FD68CD16880AAF');
        $this->addSql('ALTER TABLE manifestation_transport DROP CONSTRAINT FK_41F1329CD8E394E');
        $this->addSql('ALTER TABLE manifestation_transport DROP CONSTRAINT FK_41F13299909C13F');
        $this->addSql('DROP TABLE equipement_sportif');
        $this->addSql('DROP TABLE main_oeuvre');
        $this->addSql('DROP TABLE manifestation');
        $this->addSql('DROP TABLE manifestation_equipement_sportif');
        $this->addSql('DROP TABLE manifestation_main_oeuvre');
        $this->addSql('DROP TABLE manifestation_materiel');
        $this->addSql('DROP TABLE manifestation_transport');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE transport');
    }
}
