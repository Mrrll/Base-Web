<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210728001233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE TABLE Users (
            id BIGINT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            address_id BIGINT DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE Address (
            id BIGINT AUTO_INCREMENT NOT NULL,
            address VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql(
            'ALTER TABLE Users ADD FOREIGN KEY (address_id) REFERENCES Address(id) ON DELETE CASCADE;'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Address');
        $this->addSql('DROP TABLE Users');
    }
}
