<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120313185011 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `roles` (
              `id` INT(11) unsigned AUTO_INCREMENT NOT NULL,
              `name` VARCHAR(50) NOT NULL,
              PRIMARY KEY(id),
              UNIQUE KEY `name` (`name`)
            ) ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `roles`');
    }
}
