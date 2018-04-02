<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180331145751 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE Clients (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(15) NOT NULL, password_value VARCHAR(15) NOT NULL, email_value VARCHAR(100) NOT NULL, phone_value VARCHAR(15) NOT NULL, name_firstName VARCHAR(15) NOT NULL, name_lastName VARCHAR(15) NOT NULL, address_civicNumberAndRoad VARCHAR(15) NOT NULL, address_city VARCHAR(15) NOT NULL, address_province VARCHAR(2) NOT NULL, address_postalCode VARCHAR(6) NOT NULL, UNIQUE INDEX UK_Clients_username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('DROP TABLE Clients');
  }

  public function postUp(Schema $schema) {
    $this->connection->exec("INSERT INTO Clients(username, password_value, email_value, phone_value, name_firstname, name_lastname, address_civicNumberAndRoad, address_city, address_province, address_postalCode) VALUE ('user', '12345', '1237801@cstj.qc.ca', '4506753349', 'Alexandre', 'Parent', '485 Fournier', 'Saint-Jérôme', 'QC', 'J7Z4V2')");
  }
}
