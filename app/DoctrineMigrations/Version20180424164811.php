<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180424164811 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE UNIQUE INDEX UK_Orders_stripeToken ON orders (stripeToken)');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('DROP INDEX UK_Orders_stripeToken ON Orders');
  }
}
