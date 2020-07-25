<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725204144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doc_img_patient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, doc_size INT NOT NULL, updated_at DATETIME NOT NULL, mime_type VARCHAR(127) NOT NULL, visible TINYINT(1) NOT NULL, description VARCHAR(127) DEFAULT NULL, original_filename VARCHAR(127) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD doc_img_patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA05C3639 FOREIGN KEY (doc_img_patient_id) REFERENCES doc_img_patient (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBA05C3639 ON patient (doc_img_patient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA05C3639');
        $this->addSql('DROP TABLE doc_img_patient');
        $this->addSql('DROP INDEX IDX_1ADAD7EBA05C3639 ON patient');
        $this->addSql('ALTER TABLE patient DROP doc_img_patient_id');
    }
}
