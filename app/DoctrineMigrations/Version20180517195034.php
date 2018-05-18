<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180517195034 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE items ADD minimalCount INT NOT NULL DEFAULT 0, CHANGE count count INT NOT NULL DEFAULT 0');
    $this->addSql('ALTER TABLE orderitems CHANGE product product BIGINT UNSIGNED NOT NULL');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE Items DROP minimalCount, CHANGE count count BIGINT UNSIGNED NOT NULL');
    $this->addSql('ALTER TABLE OrderItems CHANGE product product BIGINT UNSIGNED DEFAULT NULL');
  }
}
