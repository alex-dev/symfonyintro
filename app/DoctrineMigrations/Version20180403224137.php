<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180403224137 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE TABLE Clients (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', phone VARCHAR(15) NOT NULL, name_firstName VARCHAR(15) NOT NULL, name_lastName VARCHAR(15) NOT NULL, address_civicNumberAndRoad VARCHAR(15) NOT NULL, address_city VARCHAR(15) NOT NULL, address_province VARCHAR(2) NOT NULL, address_postalCode VARCHAR(7) NOT NULL, UNIQUE INDEX UNIQ_CF7517E892FC23A8 (username_canonical), UNIQUE INDEX UNIQ_CF7517E8A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_CF7517E8C05FB297 (confirmation_token), UNIQUE INDEX UK_Clients_username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('DROP TABLE Clients');
  }

  public function postUp(Schema $schema) {
    $this->connection->exec('INSERT INTO Clients(username, username_canonical, email, email_canonical, enabled, password, roles, phone, name_firstName, name_lastName, address_civicNumberAndRoad, address_city, address_province, address_postalCode) VALUE (\'administrator\', \'administrator\', \'alexandreparent_dev@outlook.com\', \'alexandreparent_dev@outlook.com\', TRUE, \'$2a$12$ERjyfN8r.5l22GLALi9fzOk44CWW/retOfl2iCLw1gZGDZ4hVuHyK\', \'a:1:{i:0;s:10:"ROLE_ADMIN";}\', \'4504381580\', \'Alexandre\', \'Parent\', \'480 fournier\', \'St-Jerome\', \'QC\', \'J7Z4V2\')');
    $this->connection->exec('INSERT INTO Clients(username, username_canonical, email, email_canonical, enabled, password, roles, phone, name_firstName, name_lastName, address_civicNumberAndRoad, address_city, address_province, address_postalCode) VALUE (\'aparent\', \'aparent\', \'1237801@cstj.qc.ca\', \'1237801@cstj.qc.ca\', TRUE, \'$2a$12$ERjyfN8r.5l22GLALi9fzOk44CWW/retOfl2iCLw1gZGDZ4hVuHyK\', \'a:0:{}\', \'4504381580\', \'Alexandre\', \'Parent\', \'480 fournier\', \'St-Jerome\', \'QC\', \'J7Z4V2\')');
    $this->connection->exec('INSERT INTO Clients(username, username_canonical, email, email_canonical, enabled, password, roles, phone, name_firstName, name_lastName, address_civicNumberAndRoad, address_city, address_province, address_postalCode) VALUE (\'amartel\', \'amartel\', \'amartel@cstj.qc.ca\', \'amartel@cstj.qc.ca\', TRUE, \'$2a$12$ERjyfN8r.5l22GLALi9fzOk44CWW/retOfl2iCLw1gZGDZ4hVuHyK\', \'a:0:{}\', \'4504381580\', \'Alain\', \'Martel\', \'480 fournier\', \'St-Jerome\', \'QC\', \'J7Z4V2\')');
  }
}
