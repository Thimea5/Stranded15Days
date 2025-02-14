<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214150257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, effet VARCHAR(255) NOT NULL, nombre INT DEFAULT NULL, rarete VARCHAR(255) NOT NULL, actif TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, effet VARCHAR(255) DEFAULT NULL, rarete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progression_inventaire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progression_survivant (id INT AUTO_INCREMENT NOT NULL, progression_id_id INT NOT NULL, faim TINYINT(1) NOT NULL, soif INT NOT NULL, maladie TINYINT(1) NOT NULL, exploration TINYINT(1) NOT NULL, INDEX IDX_1DF6C03B7CE0B3A5 (progression_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progression_utilisateur (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, progression_inventaire_id INT DEFAULT NULL, jour INT DEFAULT NULL, UNIQUE INDEX UNIQ_BC58001FC6EE5C49 (id_utilisateur_id), INDEX IDX_BC58001F184A68C6 (progression_inventaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survivant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE progression_survivant ADD CONSTRAINT FK_1DF6C03B7CE0B3A5 FOREIGN KEY (progression_id_id) REFERENCES progression_utilisateur (id)');
        $this->addSql('ALTER TABLE progression_utilisateur ADD CONSTRAINT FK_BC58001FC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE progression_utilisateur ADD CONSTRAINT FK_BC58001F184A68C6 FOREIGN KEY (progression_inventaire_id) REFERENCES progression_inventaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progression_survivant DROP FOREIGN KEY FK_1DF6C03B7CE0B3A5');
        $this->addSql('ALTER TABLE progression_survivant_survivant DROP FOREIGN KEY FK_82BD8AAD15B4F3B');
        $this->addSql('ALTER TABLE progression_survivant_survivant DROP FOREIGN KEY FK_82BD8AAE9AE49B');
        $this->addSql('ALTER TABLE progression_utilisateur DROP FOREIGN KEY FK_BC58001FC6EE5C49');
        $this->addSql('ALTER TABLE progression_utilisateur DROP FOREIGN KEY FK_BC58001F184A68C6');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE progression_inventaire');
        $this->addSql('DROP TABLE progression_survivant');
        $this->addSql('DROP TABLE progression_utilisateur');
        $this->addSql('DROP TABLE survivant');
        $this->addSql('DROP TABLE utilisateur');
    }
}
