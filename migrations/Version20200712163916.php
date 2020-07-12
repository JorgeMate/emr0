<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712163916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historia (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, patient_id INT NOT NULL, date DATE NOT NULL, problem VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_435C8E7AA76ED395 (user_id), INDEX IDX_435C8E7A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historia ADD CONSTRAINT FK_435C8E7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historia ADD CONSTRAINT FK_435C8E7A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE historia');
    }
}
