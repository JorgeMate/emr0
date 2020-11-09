<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012155115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, report_type_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, INDEX IDX_C42F7784A5D5F193 (report_type_id), INDEX IDX_C42F7784A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_part (id INT AUTO_INCREMENT NOT NULL, report_id INT NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_3A239D3D4BD2A4C0 (report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_type (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, INDEX IDX_FFF2BAD25932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A5D5F193 FOREIGN KEY (report_type_id) REFERENCES report_type (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report_part ADD CONSTRAINT FK_3A239D3D4BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
        $this->addSql('ALTER TABLE report_type ADD CONSTRAINT FK_FFF2BAD25932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_part DROP FOREIGN KEY FK_3A239D3D4BD2A4C0');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A5D5F193');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE report_part');
        $this->addSql('DROP TABLE report_type');
    }
}
