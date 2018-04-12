<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180412134723 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE TABLE Orders (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, client BIGINT UNSIGNED DEFAULT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_E283F8D8C7440455 (client), UNIQUE INDEX UK_Orders_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE OrderItems (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, `order` BIGINT UNSIGNED DEFAULT NULL, product BIGINT UNSIGNED DEFAULT NULL, cost BIGINT UNSIGNED DEFAULT NULL, quantity INT UNSIGNED NOT NULL, INDEX IDX_7F568F95F5299398 (`order`), INDEX IDX_7F568F95D34A04AD (product), UNIQUE INDEX UNIQ_7F568F95182694FC (cost), UNIQUE INDEX UK_OrderItems_product_order (product, `order`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE Orders ADD CONSTRAINT FK_E283F8D8C7440455 FOREIGN KEY (client) REFERENCES Clients (id)');
    $this->addSql('ALTER TABLE OrderItems ADD CONSTRAINT FK_7F568F95F5299398 FOREIGN KEY (`order`) REFERENCES Orders (id)');
    $this->addSql('ALTER TABLE OrderItems ADD CONSTRAINT FK_7F568F95D34A04AD FOREIGN KEY (product) REFERENCES Products (id)');
    $this->addSql('ALTER TABLE OrderItems ADD CONSTRAINT FK_7F568F95182694FC FOREIGN KEY (cost) REFERENCES QuantityScalars (id)');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE OrderItems DROP FOREIGN KEY FK_7F568F95F5299398');
    $this->addSql('DROP TABLE Orders');
    $this->addSql('DROP TABLE OrderItems');
  }
}
