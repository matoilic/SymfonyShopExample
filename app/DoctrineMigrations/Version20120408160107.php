<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120408160107 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
          CREATE TABLE `category_texts`(
            `category_id` INT(11) UNSIGNED NOT NULL,
            `locale` CHAR(2) NOT NULL,
            `name` VARCHAR(50),
            PRIMARY KEY(`category_id`, `locale`),
            FOREIGN KEY(`category_id`) REFERENCES `categories`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
          ) ENGINE=InnoDB
        ");

        $this->addSql("
          INSERT INTO `category_texts` (`category_id`, `locale`, `name`)
           SELECT `id`, 'de', `name` FROM `categories`
        ");

        $this->addSql("
          ALTER TABLE `categories` DROP COLUMN `name`
        ");
    }

    public function down(Schema $schema)
    {
        throw new \Exception("migration not reversible");
    }
}
