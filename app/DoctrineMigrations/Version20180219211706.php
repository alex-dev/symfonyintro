<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use AppBundle\Type\UUID;

class Version20180219211706 extends AbstractMigration
{
  public function up(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE TABLE ProductStates (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, nameTranslationKey VARCHAR(128) NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', UNIQUE INDEX UK_ProductStates_key (`key`), UNIQUE INDEX UK_ProductStates_name (nameTranslationKey), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Items (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, product BIGINT UNSIGNED NOT NULL, cost BIGINT UNSIGNED NOT NULL, state BIGINT UNSIGNED NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_20DFC649D34A04AD (product), UNIQUE INDEX UNIQ_20DFC649182694FC (cost), INDEX IDX_20DFC649A393D2FB (state), UNIQUE INDEX UK_Items_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649D34A04AD FOREIGN KEY (product) REFERENCES Products (id)');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649182694FC FOREIGN KEY (cost) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649A393D2FB FOREIGN KEY (state) REFERENCES ProductStates (id)');
  }

  public function down(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE Items DROP FOREIGN KEY FK_20DFC649A393D2FB');
    $this->addSql('DROP TABLE ProductStates');
    $this->addSql('DROP TABLE Items');
  }

  public function postUp(Schema $schema) {
    {
      $this->connection->insert('Architectures', ['id'=>4, 'discriminator'=>'memory', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_US']);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_CA']);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'fr_CA']);
      $this->connection->insert('MemoryArchitectures', ['id'=>4]);      
    }

    $this->insertStates($schema);
    $this->insertUnits($schema);
    $this->insertItems($schema);
  }

  private function insertItems(Schema $schema) {
    for ($i = 0; $i < 500; ++$i) {
      $this->connection->insert('QuantityScalars', ['id'=>31 + $i, 'unit'=>24, 'value'=>rand(25, 75)]);
      $this->connection->insert('Items', ['product'=>rand(1, 15), 'cost'=>31 + $i, 'state'=>rand(1, 2), '`key`'=>UUID::create()->toHex()]);
    }
  }

  private function insertUnits(Schema $schema) {
    $prefix = 'Quantity';
    $this->connection->insert($prefix.'Converters', ['id'=>19, 'discriminator'=>'money']);
    $this->connection->insert($prefix.'Dimensions', ['id'=>4, 'name'=>'Money', 'symbol'=>'$']);
    $this->connection->insert($prefix.'UnitDimensions', ['id'=>4, 'dimension'=>4, 'exponent'=>1]);
    $this->connection->insert($prefix.'Units', ['id'=>24, 'converter'=>19, '`key`'=>'cad']);
    $this->connection->insert($prefix.'Units', ['id'=>25, 'converter'=>19, '`key`'=>'usd']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'Canadian dollars', 'symbol'=>'CAD$', 'locale'=>'en_US']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'Canadian dollars', 'symbol'=>'CAD$', 'locale'=>'en_CA']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'dollars canadiens', 'symbol'=>'$CAD', 'locale'=>'fr_CA']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'American dollars', 'symbol'=>'US$', 'locale'=>'en_US']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'American dollars', 'symbol'=>'US$', 'locale'=>'en_CA']);
    $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'dollars américains', 'symbol'=>'$US', 'locale'=>'fr_CA']);
    $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>24, 'dimension'=>4]);
    $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>25, 'dimension'=>4]);
  }

  private function insertStates(Schema $schema) {
    $prefix = 'ProductState';
    $this->connection->insert($prefix.'s', ['id'=>1, 'nameTranslationKey'=>'app.product.state.new', '`key`'=>UUID::create()->toHex()]);
    $this->connection->insert($prefix.'s', ['id'=>2, 'nameTranslationKey'=>'app.product.state.used', '`key`'=>UUID::create()->toHex()]);
  }
}
