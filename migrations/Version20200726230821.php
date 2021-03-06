<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726230821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE center (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, contact_person VARCHAR(255) DEFAULT NULL, tel VARCHAR(63) DEFAULT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(127) DEFAULT NULL, postcode VARCHAR(31) DEFAULT NULL, city VARCHAR(63) DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, ssaas_account_name VARCHAR(127) DEFAULT NULL, ssaas_api_key VARCHAR(127) DEFAULT NULL, UNIQUE INDEX UNIQ_40F0EB24A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consult (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, consult VARCHAR(255) NOT NULL, result VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_4D02C9E26B899279 (patient_id), INDEX IDX_4D02C9E2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_center_group (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, INDEX IDX_60D300225932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_img_patient (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, name VARCHAR(255) NOT NULL, doc_size INT NOT NULL, updated_at DATETIME NOT NULL, mime_type VARCHAR(127) NOT NULL, visible TINYINT(1) NOT NULL, description VARCHAR(127) DEFAULT NULL, original_filename VARCHAR(127) NOT NULL, INDEX IDX_43C49BA6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_patient (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, name VARCHAR(255) NOT NULL, doc_size INT NOT NULL, updated_at DATETIME NOT NULL, mime_type VARCHAR(127) NOT NULL, visible TINYINT(1) NOT NULL, description VARCHAR(127) DEFAULT NULL, original_filename VARCHAR(127) NOT NULL, INDEX IDX_C5385F356B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_user (id INT AUTO_INCREMENT NOT NULL, doc_center_group_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, doc_size INT NOT NULL, updated_at DATETIME NOT NULL, mime_type VARCHAR(127) NOT NULL, visible TINYINT(1) NOT NULL, description VARCHAR(127) DEFAULT NULL, original_filename VARCHAR(127) NOT NULL, INDEX IDX_D489619F4252D4B0 (doc_center_group_id), INDEX IDX_D489619FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historia (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, patient_id INT NOT NULL, date DATE NOT NULL, problem VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_435C8E7AA76ED395 (user_id), INDEX IDX_435C8E7A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insurance (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, code VARCHAR(10) DEFAULT NULL, contact VARCHAR(127) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, tel VARCHAR(31) DEFAULT NULL, cel VARCHAR(31) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_640EAF4C5932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicat (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, medicat VARCHAR(127) NOT NULL, dosis VARCHAR(127) DEFAULT NULL, stop_at DATETIME DEFAULT NULL, INDEX IDX_64B79F0C6B899279 (patient_id), INDEX IDX_64B79F0CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opera (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, treatment_id INT NOT NULL, place_id INT DEFAULT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, made_at DATETIME DEFAULT NULL, value DOUBLE PRECISION DEFAULT \'0\' NOT NULL, INDEX IDX_DFDFF46C6B899279 (patient_id), INDEX IDX_DFDFF46C471C0366 (treatment_id), INDEX IDX_DFDFF46CDA6A219 (place_id), INDEX IDX_DFDFF46CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, insurance_id INT DEFAULT NULL, source_id INT DEFAULT NULL, firstname VARCHAR(127) DEFAULT NULL, lastname VARCHAR(127) NOT NULL, sex TINYINT(1) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, house_no SMALLINT DEFAULT NULL, house_txt VARCHAR(15) DEFAULT NULL, city VARCHAR(127) DEFAULT NULL, postcode VARCHAR(31) DEFAULT NULL, tel VARCHAR(31) DEFAULT NULL, cel VARCHAR(31) DEFAULT NULL, created_at DATETIME NOT NULL, contact VARCHAR(127) DEFAULT NULL, tel_con VARCHAR(31) DEFAULT NULL, doctor VARCHAR(127) DEFAULT NULL, tel_doc VARCHAR(31) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, code1 VARCHAR(63) DEFAULT NULL, code2 VARCHAR(63) DEFAULT NULL, INDEX IDX_1ADAD7EBA76ED395 (user_id), INDEX IDX_1ADAD7EBD1E63CD1 (insurance_id), INDEX IDX_1ADAD7EB953C1C61 (source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, center_id INT NOT NULL, name VARCHAR(127) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, contact VARCHAR(127) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, tel VARCHAR(31) DEFAULT NULL, cel VARCHAR(31) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_741D53CD5932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, code INT DEFAULT NULL, contact VARCHAR(127) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, tel VARCHAR(31) DEFAULT NULL, cel VARCHAR(31) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_5F8A7F735932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, value DOUBLE PRECISION DEFAULT \'0\' NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_98013C31C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, center_id INT NOT NULL, name VARCHAR(127) NOT NULL, INDEX IDX_8CDE57295932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, center_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(127) NOT NULL, lastname VARCHAR(127) DEFAULT NULL, tel VARCHAR(63) DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, medic TINYINT(1) DEFAULT NULL, cod VARCHAR(3) DEFAULT NULL, title VARCHAR(15) DEFAULT NULL, speciality VARCHAR(127) DEFAULT NULL, internal TINYINT(1) DEFAULT NULL, tax_code VARCHAR(63) DEFAULT NULL, reg_code1 VARCHAR(63) DEFAULT NULL, reg_code2 VARCHAR(63) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495932F377 (center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE center ADD CONSTRAINT FK_40F0EB24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E26B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE doc_center_group ADD CONSTRAINT FK_60D300225932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE doc_img_patient ADD CONSTRAINT FK_43C49BA6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE doc_patient ADD CONSTRAINT FK_C5385F356B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE doc_user ADD CONSTRAINT FK_D489619F4252D4B0 FOREIGN KEY (doc_center_group_id) REFERENCES doc_center_group (id)');
        $this->addSql('ALTER TABLE doc_user ADD CONSTRAINT FK_D489619FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historia ADD CONSTRAINT FK_435C8E7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historia ADD CONSTRAINT FK_435C8E7A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE insurance ADD CONSTRAINT FK_640EAF4C5932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE medicat ADD CONSTRAINT FK_64B79F0C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE medicat ADD CONSTRAINT FK_64B79F0CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE opera ADD CONSTRAINT FK_DFDFF46C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE opera ADD CONSTRAINT FK_DFDFF46C471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE opera ADD CONSTRAINT FK_DFDFF46CDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE opera ADD CONSTRAINT FK_DFDFF46CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBD1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD5932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F735932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE57295932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doc_center_group DROP FOREIGN KEY FK_60D300225932F377');
        $this->addSql('ALTER TABLE insurance DROP FOREIGN KEY FK_640EAF4C5932F377');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD5932F377');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F735932F377');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE57295932F377');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495932F377');
        $this->addSql('ALTER TABLE doc_user DROP FOREIGN KEY FK_D489619F4252D4B0');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBD1E63CD1');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E26B899279');
        $this->addSql('ALTER TABLE doc_img_patient DROP FOREIGN KEY FK_43C49BA6B899279');
        $this->addSql('ALTER TABLE doc_patient DROP FOREIGN KEY FK_C5385F356B899279');
        $this->addSql('ALTER TABLE historia DROP FOREIGN KEY FK_435C8E7A6B899279');
        $this->addSql('ALTER TABLE medicat DROP FOREIGN KEY FK_64B79F0C6B899279');
        $this->addSql('ALTER TABLE opera DROP FOREIGN KEY FK_DFDFF46C6B899279');
        $this->addSql('ALTER TABLE opera DROP FOREIGN KEY FK_DFDFF46CDA6A219');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB953C1C61');
        $this->addSql('ALTER TABLE opera DROP FOREIGN KEY FK_DFDFF46C471C0366');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31C54C8C93');
        $this->addSql('ALTER TABLE center DROP FOREIGN KEY FK_40F0EB24A76ED395');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E2A76ED395');
        $this->addSql('ALTER TABLE doc_user DROP FOREIGN KEY FK_D489619FA76ED395');
        $this->addSql('ALTER TABLE historia DROP FOREIGN KEY FK_435C8E7AA76ED395');
        $this->addSql('ALTER TABLE medicat DROP FOREIGN KEY FK_64B79F0CA76ED395');
        $this->addSql('ALTER TABLE opera DROP FOREIGN KEY FK_DFDFF46CA76ED395');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE center');
        $this->addSql('DROP TABLE consult');
        $this->addSql('DROP TABLE doc_center_group');
        $this->addSql('DROP TABLE doc_img_patient');
        $this->addSql('DROP TABLE doc_patient');
        $this->addSql('DROP TABLE doc_user');
        $this->addSql('DROP TABLE historia');
        $this->addSql('DROP TABLE insurance');
        $this->addSql('DROP TABLE medicat');
        $this->addSql('DROP TABLE opera');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
