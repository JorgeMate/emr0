<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200711215036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_5F8A7F735932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F735932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE patient ADD source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB953C1C61 ON patient (source_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB953C1C61');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP INDEX IDX_1ADAD7EB953C1C61 ON patient');
        $this->addSql('ALTER TABLE patient DROP source_id');
    }
}
