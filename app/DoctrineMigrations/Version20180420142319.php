<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180420142319 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE orderitems RENAME INDEX idx_7f568f95f5299398 TO IDX_7F568F95C6898E08');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE OrderItems RENAME INDEX idx_7f568f95c6898e08 TO IDX_7F568F95F5299398');
  }
}
