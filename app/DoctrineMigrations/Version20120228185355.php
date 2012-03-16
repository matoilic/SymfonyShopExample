<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120228185355 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE `products` (
                `id` INT(11) unsigned AUTO_INCREMENT NOT NULL,
                `category_id` INT(11) unsigned NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL,
                `image` VARCHAR(255) NOT NULL,
                `price` DECIMAL(20,2) NOT NULL,
                `sales_start` DATE NOT NULL,
                `sales_end` DATE NULL,
                `stock` INT(11) unsigned NOT NULL DEFAULT 0,
                `total_sales` INT(11) unsigned NOT NULL DEFAULT 0,
                `total_revenue` DECIMAL(20,2) NOT NULL DEFAULT 0,
                PRIMARY KEY(`id`),
                FOREIGN KEY(`category_id`) REFERENCES `categories`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
                KEY `sales_start` (`sales_start`),
                KEY `sales_end` (`sales_end`),
                KEY `stock` (`stock`),
                KEY `total_sales` (`total_sales`),
                KEY `total_revenue` (`total_revenue`)
            ) ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE `products`");
    }
}
