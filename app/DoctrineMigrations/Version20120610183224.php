<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120610183224 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE `orders`
              ADD `shipping_type` CHAR(1) NOT NULL,
              ADD `shipping_fee` DECIMAL(20,2) NOT NULL,
              ADD `payment_type` CHAR(1) NOT NULL,
              ADD `payment_fee` DECIMAL(20,2) NOT NULL
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE `orders`
              DROP COLUMN `shipping_type`,
              DROP COLUMN `shipping_fee`,
              DROP COLUMN `payment_type`,
              DROP COLUMN `payment_fee`
        ');
    }
}
