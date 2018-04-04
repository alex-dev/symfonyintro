<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180404002434 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('DROP INDEX UK_Clients_username ON clients');
    $this->addSql('ALTER TABLE clients CHANGE username username VARCHAR(15) NOT NULL, CHANGE username_canonical username_canonical VARCHAR(15) NOT NULL');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE Clients CHANGE username_canonical username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, CHANGE username username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci');
    $this->addSql('CREATE UNIQUE INDEX UK_Clients_username ON Clients (username)');
  }
}
