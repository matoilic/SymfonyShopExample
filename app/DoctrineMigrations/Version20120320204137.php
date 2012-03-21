<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120320204137 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `addresses` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `first_name` VARCHAR(80),
              `last_name` VARCHAR(80),
              `company` VARCHAR(80),
              `address_line1` VARCHAR(255) NOT NULL,
              `address_line2` VARCHAR(255),
              `zip_code` INT(4) NOT NULL,
              `city` VARCHAR(120) NOT NULL,
              PRIMARY KEY(`id`)
            ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `addresses`');
    }
}
