<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712041237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicat (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, medicat VARCHAR(127) NOT NULL, dosis VARCHAR(127) DEFAULT NULL, stop_at DATETIME DEFAULT NULL, INDEX IDX_64B79F0C6B899279 (patient_id), INDEX IDX_64B79F0CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicat ADD CONSTRAINT FK_64B79F0C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE medicat ADD CONSTRAINT FK_64B79F0CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medicat');
    }
}
