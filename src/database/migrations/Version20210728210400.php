<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210728210400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE Products (
            id BIGINT AUTO_INCREMENT NOT NULL,
            shipment_id BIGINT DEFAULT NULL,
            name VARCHAR(255) DEFAULT NULL,
            UNIQUE INDEX UNIQ_6FBC94267FE4B2B (shipment_id),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE Shipments (
            id BIGINT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql('ALTER TABLE Products ADD FOREIGN KEY (shipment_id) REFERENCES Shipments(id);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE Products');
        $this->addSql('DROP TABLE Shipments');
    }
}
