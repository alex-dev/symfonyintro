<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180305154902 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql("ALTER TABLE QuantityUnits ADD discriminator VARCHAR(50) NOT NULL DEFAULT 'unit'");
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE QuantityUnits DROP discriminator');
  }

  public function postUp(Schema $schema) {
    $this->connection->exec("UPDATE QuantityUnits SET discriminator = 'currency' WHERE id IN (24, 25)");
    $this->connection->exec("ALTER TABLE QuantityUnits CHANGE discriminator discriminator VARCHAR(50) NOT NULL");
    
  }
}
