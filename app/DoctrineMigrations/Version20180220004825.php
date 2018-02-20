<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180220004825 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E7B3BB5CD34A04AD');
    $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E7B3BB5CD34A04AD FOREIGN KEY (product) REFERENCES Items (product)');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE Images DROP FOREIGN KEY FK_E7B3BB5CD34A04AD');
    $this->addSql('ALTER TABLE Images ADD CONSTRAINT FK_E7B3BB5CD34A04AD FOREIGN KEY (product) REFERENCES products (id)');
  }
}
