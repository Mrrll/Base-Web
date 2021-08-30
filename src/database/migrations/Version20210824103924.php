<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824103924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Tabla Imagenes Herencia de la tabla de clases';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profiles DROP updated_at, DROP created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530BF396750');
        $this->addSql('DROP TABLE Image');
        $this->addSql('ALTER TABLE profiles ADD updated_at DATETIME DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL');
    }
}
