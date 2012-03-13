<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120313185140 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE `roles_users` (
              `role_id` INT(11) unsigned NOT NULL,
              `user_id` INT(11) unsigned NOT NULL,
              PRIMARY KEY (`role_id`, `user_id`),
              FOREIGN KEY(`role_id`) REFERENCES `roles`(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
              FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) ENGINE=InnoDB
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `roles_users`');
    }
}
