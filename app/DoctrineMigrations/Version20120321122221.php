<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120321122221 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
          CREATE TABLE `order_items` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `order_id` INT(11) UNSIGNED NOT NULL,
            `product_id` INT(11) UNSIGNED NOT NULL,
            `unit_price` DECIMAL(20,2) NOT NULL,
            `unit_discount` DECIMAL(20,2) NOT NULL DEFAULT 0,
            `quantity` TINYINT(3) NOT NULL,
            `total_amount` DECIMAL(20,2) NOT NULL,
            PRIMARY KEY(`id`),
            FOREIGN KEY(`order_id`) REFERENCES `orders`(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY(`product_id`) REFERENCES `products`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
            UNIQUE KEY `product` (`order_id`, `product_id`)
          ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `order_items`');
    }
}
