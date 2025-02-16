<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216003220 extends AbstractMigration
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
        $this->addSql('CREATE TABLE progression_inventaire (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_A679F241FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progression_survivant (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, survivant_id INT NOT NULL, faim INT NOT NULL, soif INT NOT NULL, maladie TINYINT(1) NOT NULL, exploration TINYINT(1) NOT NULL, mort TINYINT(1) NOT NULL, INDEX IDX_1DF6C03BFB88E14F (utilisateur_id), INDEX IDX_1DF6C03BE9AE49B (survivant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progression_utilisateur (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, INDEX IDX_BC58001FC6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survivant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE progression_inventaire ADD CONSTRAINT FK_A679F241FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE progression_survivant ADD CONSTRAINT FK_1DF6C03BFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE progression_survivant ADD CONSTRAINT FK_1DF6C03BE9AE49B FOREIGN KEY (survivant_id) REFERENCES survivant (id)');
        $this->addSql('ALTER TABLE progression_utilisateur ADD CONSTRAINT FK_BC58001FC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progression_inventaire DROP FOREIGN KEY FK_A679F241FB88E14F');
        $this->addSql('ALTER TABLE progression_survivant DROP FOREIGN KEY FK_1DF6C03BFB88E14F');
        $this->addSql('ALTER TABLE progression_survivant DROP FOREIGN KEY FK_1DF6C03BE9AE49B');
        $this->addSql('ALTER TABLE progression_utilisateur DROP FOREIGN KEY FK_BC58001FC6EE5C49');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE progression_inventaire');
        $this->addSql('DROP TABLE progression_survivant');
        $this->addSql('DROP TABLE progression_utilisateur');
        $this->addSql('DROP TABLE survivant');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
