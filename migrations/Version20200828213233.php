<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828213233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, opera_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, issued DATE NOT NULL, paid DATE DEFAULT NULL, INDEX IDX_556BA43441301C57 (opera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, login_time DATETIME NOT NULL, ip VARCHAR(63) NOT NULL, agent VARCHAR(255) NOT NULL, logout_time DATETIME DEFAULT NULL, logout_type SMALLINT DEFAULT NULL, INDEX IDX_6429094EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA43441301C57 FOREIGN KEY (opera_id) REFERENCES opera (id)');
        $this->addSql('ALTER TABLE user_log ADD CONSTRAINT FK_6429094EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE opera ADD operateur VARCHAR(63) DEFAULT NULL, ADD assistent VARCHAR(63) DEFAULT NULL, ADD omloop VARCHAR(63) DEFAULT NULL, ADD anesthesie VARCHAR(63) DEFAULT NULL, ADD anesthesie_md VARCHAR(63) DEFAULT NULL, ADD re_ok TINYINT(1) DEFAULT \'0\' NOT NULL, ADD complica TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE user_log');
        $this->addSql('ALTER TABLE opera DROP operateur, DROP assistent, DROP omloop, DROP anesthesie, DROP anesthesie_md, DROP re_ok, DROP complica');
    }
}
