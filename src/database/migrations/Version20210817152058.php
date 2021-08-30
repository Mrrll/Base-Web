<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817152058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Tabla de perfiles';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, mobile INT DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, birthday DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8B308530A76ED395 (user_id), UNIQUE INDEX UNIQ_EF687F2E7927C74 (dni), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profiles');
    }
}
