<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20120228183458 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE `categories` (
              `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(50) NOT NULL,
              PRIMARY KEY(id)
            ) ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE `products`");
    }
}
