<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725204947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_img_patient ADD patient_id INT NOT NULL');
        $this->addSql('ALTER TABLE doc_img_patient ADD CONSTRAINT FK_43C49BA6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_43C49BA6B899279 ON doc_img_patient (patient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_img_patient DROP FOREIGN KEY FK_43C49BA6B899279');
        $this->addSql('DROP INDEX IDX_43C49BA6B899279 ON doc_img_patient');
        $this->addSql('ALTER TABLE doc_img_patient DROP patient_id');
    }
}
