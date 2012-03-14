<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120313184406 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `users` (
              `id` INT(11) unsigned AUTO_INCREMENT NOT NULL,
              `first_name` VARCHAR(80) NOT NULL,
              `last_name` VARCHAR(80) NOT NULL,
              `email` VARCHAR(120) NOT NULL,
              `password` VARCHAR(90) NOT NULL,
              `salt` VARCHAR(32) NOT NULL,
              PRIMARY KEY(`id`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB
        ');

    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `users`');
    }
}
