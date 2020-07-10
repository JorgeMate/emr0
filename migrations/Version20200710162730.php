<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200710162730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_user ADD doc_center_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doc_user ADD CONSTRAINT FK_D489619F4252D4B0 FOREIGN KEY (doc_center_group_id) REFERENCES doc_center_group (id)');
        $this->addSql('CREATE INDEX IDX_D489619F4252D4B0 ON doc_user (doc_center_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_user DROP FOREIGN KEY FK_D489619F4252D4B0');
        $this->addSql('DROP INDEX IDX_D489619F4252D4B0 ON doc_user');
        $this->addSql('ALTER TABLE doc_user DROP doc_center_group_id');
    }
}
