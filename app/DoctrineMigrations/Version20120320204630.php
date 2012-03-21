<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120320204630 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `customers` (
              `id` INT(11) unsigned AUTO_INCREMENT NOT NULL,
              `address_id` INT(11) unsigned NOT NULL,
              `first_name` VARCHAR(80) NOT NULL,
              `last_name` VARCHAR(80) NOT NULL,
              `email` VARCHAR(120) NOT NULL,
              `password` VARCHAR(90) NOT NULL,
              `salt` VARCHAR(32) NOT NULL,
              `total_revenues` DECIMAL(20,2) NOT NULL DEFAULT 0,
              `total_orders` INT(11) UNSIGNED NOT NULL DEFAULT 0,
              PRIMARY KEY(`id`),
              UNIQUE KEY `email` (`email`),
              FOREIGN KEY(`address_id`) REFERENCES `addresses`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
              INDEX `total_revenues`(`total_revenues`),
              INDEX `total_orders`(`total_orders`)
            ) ENGINE=InnoDB
        ');

    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `customers`');
    }
}
