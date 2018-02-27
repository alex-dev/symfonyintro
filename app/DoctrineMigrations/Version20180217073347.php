<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use AppBundle\Type\UUID;

class Version20180217073347 extends AbstractMigration
{

  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE UNIQUE INDEX UK_Images_product_main ON images (product, main)');
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('DROP INDEX UK_Images_product_main ON Images');
  }

  public function postUp(Schema $schema) {
    {
      $this->connection->insert('Architectures', ['id'=>4, 'discriminator'=>'memory', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_US']);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_CA']);
      $this->connection->insert('ArchitectureTranslations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'fr_CA']);
      $this->connection->insert('MemoryArchitectures', ['id'=>4]);
    }
    {
      $prefix = 'Quantity';
      $this->connection->insert($prefix.'Converters', ['id'=>19, 'discriminator'=>'money', 'factor'=>1]);
      $this->connection->insert($prefix.'Converters', ['id'=>20, 'discriminator'=>'money']);
      $this->connection->insert($prefix.'Dimensions', ['id'=>4, 'name'=>'Money', 'symbol'=>'$']);
      $this->connection->insert($prefix.'UnitDimensions', ['id'=>4, 'dimension'=>4, 'exponent'=>1]);
      $this->connection->insert($prefix.'Units', ['id'=>24, 'converter'=>19, '`key`'=>'CAD']);
      $this->connection->insert($prefix.'Units', ['id'=>25, 'converter'=>20, '`key`'=>'USD']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'Canadian dollars', 'symbol'=>'CAD$', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'Canadian dollars', 'symbol'=>'CAD$', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>24, 'name'=>'dollars canadiens', 'symbol'=>'$CAD', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'American dollars', 'symbol'=>'US$', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'American dollars', 'symbol'=>'US$', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>25, 'name'=>'dollars américains', 'symbol'=>'$US', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>24, 'dimension'=>4]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>25, 'dimension'=>4]);
    }
  }
}
