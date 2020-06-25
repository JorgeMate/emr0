<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625164654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD email VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD house_no SMALLINT DEFAULT NULL, ADD house_txt VARCHAR(15) DEFAULT NULL, ADD city VARCHAR(127) DEFAULT NULL, ADD postcode VARCHAR(31) DEFAULT NULL, ADD tel VARCHAR(31) DEFAULT NULL, ADD cel VARCHAR(31) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP email, DROP address, DROP house_no, DROP house_txt, DROP city, DROP postcode, DROP tel, DROP cel');
    }
}
