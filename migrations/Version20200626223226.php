<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626223226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD cod VARCHAR(3) DEFAULT NULL, ADD title VARCHAR(15) DEFAULT NULL, ADD speciality VARCHAR(127) DEFAULT NULL, ADD internal TINYINT(1) DEFAULT NULL, ADD tax_code VARCHAR(63) DEFAULT NULL, ADD reg_code1 VARCHAR(63) DEFAULT NULL, ADD reg_code2 VARCHAR(63) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP cod, DROP title, DROP speciality, DROP internal, DROP tax_code, DROP reg_code1, DROP reg_code2');
    }
}
