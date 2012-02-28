<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
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
                PRIMARY KEY(`id`),
                FOREIGN KEY(`category_id`) REFERENCES `categories`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE `products`");
    }
}
