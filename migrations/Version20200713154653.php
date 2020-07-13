<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713154653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_patient ADD name VARCHAR(255) NOT NULL, ADD doc_size INT NOT NULL, ADD updated_at DATETIME NOT NULL, ADD mime_type VARCHAR(127) NOT NULL');
        $this->addSql('ALTER TABLE opera CHANGE value value DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_patient DROP name, DROP doc_size, DROP updated_at, DROP mime_type');
        $this->addSql('ALTER TABLE opera CHANGE value value DOUBLE PRECISION NOT NULL');
    }
}
