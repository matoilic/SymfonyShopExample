<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;


class Version20120408131451 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
          CREATE TABLE `product_texts`(
            `product_id` INT(11) UNSIGNED NOT NULL,
            `locale` CHAR(2) NOT NULL,
            `name` VARCHAR(255),
            `description` TEXT,
            PRIMARY KEY(`product_id`, `locale`),
            FOREIGN KEY(`product_id`) REFERENCES `products`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
          ) ENGINE=InnoDB
        ');

        $this->addSql("
          INSERT INTO `product_texts` (`product_id`, `locale`, `name`, `description`)
            SELECT DISTINCT `id`, 'de', `name`, `description` FROM `products`
        ");

        $this->addSql("
          ALTER TABLE `products` DROP COLUMN `name`
        ");

        $this->addSql("
          ALTER TABLE `products` DROP COLUMN `description`
        ");
    }

    public function down(Schema $schema)
    {
        throw new \Exception("migration not reversible");
    }
}
