<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120321132834 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
          CREATE TABLE `cart_items`(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `cart_id` INT(11) UNSIGNED NOT NULL,
            `product_id` INT(11) UNSIGNED NOT NULL,
            `quantity` TINYINT(3) UNSIGNED NOT NULL,
            `unit_discount` DECIMAL(20,2) NOT NULL DEFAULT 0,
            PRIMARY KEY(`id`),
            FOREIGN KEY(`cart_id`) REFERENCES `carts`(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY(`product_id`) REFERENCES `products`(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
            UNIQUE KEY `product` (`cart_id`, `product_id`)
          ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `cart_items`');
    }
}
