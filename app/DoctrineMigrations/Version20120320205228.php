<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120320205228 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
          CREATE TABLE `orders` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `customer_id` INT(11) UNSIGNED NOT NULL,
            `shipping_address_id` INT(11) UNSIGNED NOT NULL,
            `billing_address_id` INT(11) UNSIGNED NOT NULL,
            `total_amount` DECIMAL(20,2) NOT NULL,
            `tax_rate` DECIMAL(5,2) NOT NULL DEFAULT 8.0,
            `is_shipped` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
            `is_paid` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
            `created_at` DATETIME NOT NULL,
            `payment_due` DATE NOT NULL,
            PRIMARY KEY(`id`),
            FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
            FOREIGN KEY(`shipping_address_id`) REFERENCES `addresses`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
            FOREIGN KEY(`billing_address_id`) REFERENCES `addresses`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT
          ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `orders`');
    }
}
