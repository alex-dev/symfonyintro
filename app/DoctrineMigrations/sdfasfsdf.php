<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use AppBundle\Database\UUIDType;
use AppBundle\Type\UUID;

/**
 * Initial migration.
 */
class Version20180214052639 extends AbstractMigration
{
  private function insertImages(Schema $schema) {
    $this->connection->insert('Images', ['idProduct'=>1, 'filename'=>'EQXceR6SbkeuxmHoWLGV8w']);
  }

  private function insertProducts(Schema $schema, UUIDType $factory) {
    {
      $this->connection->insert('Products', ['idProduct'=>1, 'discriminator'=>'memory', 'idManufacturer'=>1, 'code'=>'','`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    }
    {
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT White', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT White', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT Blanc', 'locale'=>'en_FR']);
    }
    {
      $this->connection->insert('Memories', ['idProduct'=>1, 'idArchitecture'=>1, 'size'=>1, 'frequency'=>2]);
    }
  }

  private function insertScalars(Schema $schema) {
    $this->connection->insert('Scalars', ['idScalar'=>1, 'idUnit'=>13, 'value'=>4]);
    $this->connection->insert('Scalars', ['idScalar'=>2, 'idUnit'=>21, 'value'=>2400]);
  }
}
