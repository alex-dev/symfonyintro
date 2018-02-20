<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180220002114 extends AbstractMigration
{
  public function up(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE TABLE Items (product BIGINT UNSIGNED NOT NULL, cost BIGINT UNSIGNED NOT NULL, count BIGINT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_20DFC649182694FC (cost), PRIMARY KEY(product)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649D34A04AD FOREIGN KEY (product) REFERENCES Products (id)');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649182694FC FOREIGN KEY (cost) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE memories DROP FOREIGN KEY FK_82EA5F80267FB813');
    $this->addSql('ALTER TABLE memories DROP FOREIGN KEY FK_82EA5F8074995EFA');
    $this->addSql('ALTER TABLE memories DROP FOREIGN KEY FK_82EA5F80F7C0246A');
    $this->addSql('DROP INDEX uniq_82ea5f80f7c0246a ON memories');
    $this->addSql('CREATE UNIQUE INDEX UNIQ_F68AB0D3F7C0246A ON memories (size)');
    $this->addSql('DROP INDEX uniq_82ea5f80267fb813 ON memories');
    $this->addSql('CREATE UNIQUE INDEX UNIQ_F68AB0D3267FB813 ON memories (frequency)');
    $this->addSql('DROP INDEX idx_82ea5f8074995efa ON memories');
    $this->addSql('CREATE INDEX IDX_F68AB0D374995EFA ON memories (architecture)');
    $this->addSql('ALTER TABLE memories ADD CONSTRAINT FK_82EA5F80267FB813 FOREIGN KEY (frequency) REFERENCES quantityscalars (id)');
    $this->addSql('ALTER TABLE memories ADD CONSTRAINT FK_82EA5F8074995EFA FOREIGN KEY (architecture) REFERENCES memoryarchitectures (id)');
    $this->addSql('ALTER TABLE memories ADD CONSTRAINT FK_82EA5F80F7C0246A FOREIGN KEY (size) REFERENCES quantityscalars (id)');
  }

  public function down(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('DROP TABLE Items');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D3F7C0246A');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D3267FB813');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D374995EFA');
    $this->addSql('DROP INDEX uniq_f68ab0d3f7c0246a ON Memories');
    $this->addSql('CREATE UNIQUE INDEX UNIQ_82EA5F80F7C0246A ON Memories (size)');
    $this->addSql('DROP INDEX uniq_f68ab0d3267fb813 ON Memories');
    $this->addSql('CREATE UNIQUE INDEX UNIQ_82EA5F80267FB813 ON Memories (frequency)');
    $this->addSql('DROP INDEX idx_f68ab0d374995efa ON Memories');
    $this->addSql('CREATE INDEX IDX_82EA5F8074995EFA ON Memories (architecture)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D3F7C0246A FOREIGN KEY (size) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D3267FB813 FOREIGN KEY (frequency) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D374995EFA FOREIGN KEY (architecture) REFERENCES MemoryArchitectures (id)');
}

  public function postUp(Schema $schema) {
    for ($i = 1; $i <=15; ++$i) {
      $this->connection->insert('QuantityScalars', ['id'=>31 + $i, 'unit'=>24, 'value'=>rand(25, 75)]);
      $this->connection->insert('Items', ['product'=>$i, 'cost'=>31 + $i, 'count'=>rand(10, 500)]);
    }
  }
}
