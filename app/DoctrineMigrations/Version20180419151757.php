<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180419151757 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE orders CHANGE client client BIGINT UNSIGNED NOT NULL');
    $this->addSql('ALTER TABLE orderitems CHANGE product product BIGINT UNSIGNED NOT NULL, CHANGE `order` `order` BIGINT UNSIGNED NOT NULL');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE OrderItems CHANGE `order` `order` BIGINT UNSIGNED DEFAULT NULL, CHANGE product product BIGINT UNSIGNED DEFAULT NULL');
    $this->addSql('ALTER TABLE Orders CHANGE client client BIGINT UNSIGNED DEFAULT NULL');
  }
}
