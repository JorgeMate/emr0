<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200710234904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE center (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, contact_person VARCHAR(255) DEFAULT NULL, tel VARCHAR(63) DEFAULT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(127) DEFAULT NULL, postcode VARCHAR(31) DEFAULT NULL, city VARCHAR(63) DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, ssaas_account_name VARCHAR(127) DEFAULT NULL, ssaas_api_key VARCHAR(127) DEFAULT NULL, UNIQUE INDEX UNIQ_40F0EB24A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_center_group (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, INDEX IDX_60D300225932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_user (id INT AUTO_INCREMENT NOT NULL, doc_center_group_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, doc_size INT NOT NULL, updated_at DATETIME NOT NULL, mime_type VARCHAR(127) NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_D489619F4252D4B0 (doc_center_group_id), INDEX IDX_D489619FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(127) DEFAULT NULL, lastname VARCHAR(127) NOT NULL, sex TINYINT(1) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, house_no SMALLINT DEFAULT NULL, house_txt VARCHAR(15) DEFAULT NULL, city VARCHAR(127) DEFAULT NULL, postcode VARCHAR(31) DEFAULT NULL, tel VARCHAR(31) DEFAULT NULL, cel VARCHAR(31) DEFAULT NULL, created_at DATETIME NOT NULL, contact VARCHAR(127) DEFAULT NULL, tel_con VARCHAR(31) DEFAULT NULL, doctor VARCHAR(127) DEFAULT NULL, tel_doc VARCHAR(31) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_1ADAD7EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, center_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(127) NOT NULL, lastname VARCHAR(127) DEFAULT NULL, tel VARCHAR(63) DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, medic TINYINT(1) DEFAULT NULL, cod VARCHAR(3) DEFAULT NULL, title VARCHAR(15) DEFAULT NULL, speciality VARCHAR(127) DEFAULT NULL, internal TINYINT(1) DEFAULT NULL, tax_code VARCHAR(63) DEFAULT NULL, reg_code1 VARCHAR(63) DEFAULT NULL, reg_code2 VARCHAR(63) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE center ADD CONSTRAINT FK_40F0EB24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE doc_center_group ADD CONSTRAINT FK_60D300225932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE doc_user ADD CONSTRAINT FK_D489619F4252D4B0 FOREIGN KEY (doc_center_group_id) REFERENCES doc_center_group (id)');
        $this->addSql('ALTER TABLE doc_user ADD CONSTRAINT FK_D489619FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_center_group DROP FOREIGN KEY FK_60D300225932F377');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495932F377');
        $this->addSql('ALTER TABLE doc_user DROP FOREIGN KEY FK_D489619F4252D4B0');
        $this->addSql('ALTER TABLE center DROP FOREIGN KEY FK_40F0EB24A76ED395');
        $this->addSql('ALTER TABLE doc_user DROP FOREIGN KEY FK_D489619FA76ED395');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE center');
        $this->addSql('DROP TABLE doc_center_group');
        $this->addSql('DROP TABLE doc_user');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
    }
}
