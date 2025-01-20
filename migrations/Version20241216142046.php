<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216142046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, terrain_id INT NOT NULL, user_id INT NOT NULL, date_creation DATETIME NOT NULL, datefin DATETIME NOT NULL, INDEX IDX_42C849558A2D8B41 (terrain_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom_terrain VARCHAR(50) NOT NULL, capacite INT NOT NULL, disponible TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C87653B1BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558A2D8B41 FOREIGN KEY (terrain_id) REFERENCES terrain (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(15) NOT NULL, ADD prenom VARCHAR(25) NOT NULL, ADD email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558A2D8B41');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B1BCF5E72D');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('ALTER TABLE `user` DROP nom, DROP prenom, DROP email');
    }
}
