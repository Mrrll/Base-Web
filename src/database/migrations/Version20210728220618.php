<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210728220618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE Carts (
            id BIGINT AUTO_INCREMENT NOT NULL,
            customer_id BIGINT DEFAULT NULL,
            articulo VARCHAR(255) DEFAULT NULL,
            UNIQUE INDEX UNIQ_BA388B79395C3F3 (customer_id),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE Customers (
            id BIGINT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;');
        $this->addSql('ALTER TABLE Carts ADD FOREIGN KEY (customer_id) REFERENCES Customers(id);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE Carts');
        $this->addSql('DROP TABLE Customers');
    }
}
