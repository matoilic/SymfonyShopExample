<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120321132556 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
          CREATE TABLE `carts`(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `updated_at` DATETIME NOT NULL,
            PRIMARY KEY(`id`)
          ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `carts`');
    }
}
