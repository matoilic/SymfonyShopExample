<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120528211209 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE `product_texts`
              ADD INDEX `locale`(`locale`),
              ADD INDEX `product_id`(`product_id`)
        ');

        $this->addSql('DROP INDEX `PRIMARY` ON `product_texts`');

        $this->addSql('
            ALTER TABLE `product_texts`
              ADD `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              ADD PRIMARY KEY(`id`)
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            DROP INDEX `PRIMARY` ON `product_texts`
        ');

        $this->addSql('
            ALTER TABLE `product_texts`
              DROP COLUMN `id`,
              ADD PRIMARY KEY(`product_id`, `locale`),
              DROP INDEX `locale`,
              DROP INDEX `product_id`
        ');
    }
}
