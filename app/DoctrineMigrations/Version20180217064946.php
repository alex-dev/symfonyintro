<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180217064946 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE memories RENAME INDEX uniq_82ea5f80f7c0246a TO UNIQ_F68AB0D3F7C0246A');
    $this->addSql('ALTER TABLE memories RENAME INDEX uniq_82ea5f80267fb813 TO UNIQ_F68AB0D3267FB813');
    $this->addSql('ALTER TABLE memories RENAME INDEX idx_82ea5f8074995efa TO IDX_F68AB0D374995EFA');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE Memories RENAME INDEX uniq_f68ab0d3f7c0246a TO UNIQ_82EA5F80F7C0246A');
    $this->addSql('ALTER TABLE Memories RENAME INDEX uniq_f68ab0d3267fb813 TO UNIQ_82EA5F80267FB813');
    $this->addSql('ALTER TABLE Memories RENAME INDEX idx_f68ab0d374995efa TO IDX_82EA5F8074995EFA');
  }
}
