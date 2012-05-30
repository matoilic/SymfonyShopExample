<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;


class Version20120529192541 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE `products`
              ADD `is_featured` TINYINT NOT NULL DEFAULT 0,
              ADD INDEX `is_featured`(`is_featured`)
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE `products`
              DROP INDEX `is_featured`,
              ADD COLUMN `is_featured`
        ');

    }
}
