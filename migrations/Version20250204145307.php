<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204145307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choix (id INT AUTO_INCREMENT NOT NULL, etape_histoire_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_4F4880916B54C640 (etape_histoire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape_histoire (id INT AUTO_INCREMENT NOT NULL, histoire_id INT NOT NULL, INDEX IDX_EC2EAF979B94373 (histoire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_utilisateur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, histoire_id INT NOT NULL, satiete INT NOT NULL, soif INT NOT NULL, fatigue INT NOT NULL, UNIQUE INDEX UNIQ_7068CB64FB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_7068CB649B94373 (histoire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE histoire (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, histoire_id INT NOT NULL, UNIQUE INDEX UNIQ_338920E0FB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_338920E09B94373 (histoire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire_objet (inventaire_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_AD0C365ACE430A85 (inventaire_id), INDEX IDX_AD0C365AF520CF5A (objet_id), PRIMARY KEY(inventaire_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, satiete INT DEFAULT NULL, soif INT DEFAULT NULL, fatigue INT DEFAULT NULL, effet VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(20) NOT NULL, mdp VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F4880916B54C640 FOREIGN KEY (etape_histoire_id) REFERENCES etape_histoire (id)');
        $this->addSql('ALTER TABLE etape_histoire ADD CONSTRAINT FK_EC2EAF979B94373 FOREIGN KEY (histoire_id) REFERENCES histoire (id)');
        $this->addSql('ALTER TABLE etat_utilisateur ADD CONSTRAINT FK_7068CB64FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE etat_utilisateur ADD CONSTRAINT FK_7068CB649B94373 FOREIGN KEY (histoire_id) REFERENCES histoire (id)');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E09B94373 FOREIGN KEY (histoire_id) REFERENCES histoire (id)');
        $this->addSql('ALTER TABLE inventaire_objet ADD CONSTRAINT FK_AD0C365ACE430A85 FOREIGN KEY (inventaire_id) REFERENCES inventaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventaire_objet ADD CONSTRAINT FK_AD0C365AF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F4880916B54C640');
        $this->addSql('ALTER TABLE etape_histoire DROP FOREIGN KEY FK_EC2EAF979B94373');
        $this->addSql('ALTER TABLE etat_utilisateur DROP FOREIGN KEY FK_7068CB64FB88E14F');
        $this->addSql('ALTER TABLE etat_utilisateur DROP FOREIGN KEY FK_7068CB649B94373');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E0FB88E14F');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E09B94373');
        $this->addSql('ALTER TABLE inventaire_objet DROP FOREIGN KEY FK_AD0C365ACE430A85');
        $this->addSql('ALTER TABLE inventaire_objet DROP FOREIGN KEY FK_AD0C365AF520CF5A');
        $this->addSql('DROP TABLE choix');
        $this->addSql('DROP TABLE etape_histoire');
        $this->addSql('DROP TABLE etat_utilisateur');
        $this->addSql('DROP TABLE histoire');
        $this->addSql('DROP TABLE inventaire');
        $this->addSql('DROP TABLE inventaire_objet');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
