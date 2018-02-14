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
  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->create($schema);
  }

  public function postUp(Schema $schema) {
    $this->connection->setautoCommit(false);
    $this->insertUnits($schema);
    $this->insertScalars($schema);
    $this->insertManufacturers($schema, new UUIDType());
    $this->insertArchitectures($schema, new UUIDType());
    $this->insertProducts($schema, new UUIDType());
    $this->insertImages($schema);
  }

  public function down(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->drop($schema);
  }

  private function insertImages(Schema $schema) {
    $this->connection->insert('Images', ['idImage'=>1, 'idProduct'=>1, 'filename'=>'']);
  }

  private function insertProducts(Schema $schema, UUIDType $factory) {
    {
      $this->connection->insert('Products', ['idProduct'=>1, 'discriminator'=>'memory', 'idManufacturer'=>1, '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    }
    {
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'', 'abbreviation'=>'', 'locale'=>'en_US']);
    }
    {
      $this->connection->insert('Memories', ['idProduct'=>1, 'size'=>1, 'frequency'=>1]);
    }
  }

  private function insertArchitectures(Schema $schema, UUIDType $factory) {
    $prefix = 'Architecture';
    
    /*   
     *   "graphic" = "GraphicAcceleratorArchitecture",
     *   "hard" = "HardDriveArchitecture",
     *   "memory" = "MemoryArchitecture",
     *   "processor" = "ProcessorArchitecture"
     */
    {
      $this->connection->insert($prefix.'s', ['idArchitecture'=>1, 'discriminator'=>'memory', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>2, 'discriminator'=>'memory', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>3, 'discriminator'=>'memory', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>4, 'discriminator'=>'memory', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    }
    {
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3L', 'abbreviation'=>'DDR4', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3L', 'abbreviation'=>'DDR4', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3L', 'abbreviation'=>'DDR4', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR3', 'abbreviation'=>'DDR4', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR3', 'abbreviation'=>'DDR4', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR3', 'abbreviation'=>'DDR4', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR2', 'abbreviation'=>'DDR4', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR2', 'abbreviation'=>'DDR4', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR2', 'abbreviation'=>'DDR4', 'locale'=>'fr_CA']);
    }
    {
    }
    {
    }
    {
      $this->connection->insert($prefix.'s', ['idArchitecture'=>1]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>2]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>3]);
      $this->connection->insert($prefix.'s', ['idArchitecture'=>4]);
    }
    {
    }
  }

  private function insertManufacturers(Schema $schema, UUIDType $factory) {
    $this->connection->insert('Manufacturers', ['idManufacturer'=>1, 'name'=>'', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    $this->connection->insert('Manufacturers', ['idManufacturer'=>1, 'name'=>'', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    $this->connection->insert('Manufacturers', ['idManufacturer'=>1, 'name'=>'', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
    $this->connection->insert('Manufacturers', ['idManufacturer'=>1, 'name'=>'', '`key`'=>$factory->convertToDatabaseValue(new UUID(), $this->connection->getDatabasePlatform())]);
  }

  private function insertScalars(Schema $schema) {
    $this->connection->insert('Scalars', ['idScalar'=>1, 'idUnit'=>1, 'value'=>0.0]);
  }

  private function insertUnits(Schema $schema) {
    $prefix = 'Quantity';

    {
      $this->connection->insert($prefix.'Converters', ['idConverter'=>1, 'discriminator'=>'zerobased', 'factor'=>1, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>2, 'discriminator'=>'zerobased', 'factor'=>10 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>3, 'discriminator'=>'zerobased', 'factor'=>10 ** 6, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>4, 'discriminator'=>'zerobased', 'factor'=>10 ** 9, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>5, 'discriminator'=>'zerobased', 'factor'=>10 ** 12, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>6, 'discriminator'=>'zerobased', 'factor'=>1024, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>7, 'discriminator'=>'zerobased', 'factor'=>1024 ** 2, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>8, 'discriminator'=>'zerobased', 'factor'=>1024 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>9, 'discriminator'=>'zerobased', 'factor'=>1024 ** 4, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>10, 'discriminator'=>'zerobased', 'factor'=>8, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>11, 'discriminator'=>'zerobased', 'factor'=>8 * 10 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>12, 'discriminator'=>'zerobased', 'factor'=>8 * 10 ** 6, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>13, 'discriminator'=>'zerobased', 'factor'=>8 * 10 ** 9, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>14, 'discriminator'=>'zerobased', 'factor'=>8 * 10 ** 12, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>15, 'discriminator'=>'zerobased', 'factor'=>8 * 1024, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>16, 'discriminator'=>'zerobased', 'factor'=>8 * 1024 ** 2, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>17, 'discriminator'=>'zerobased', 'factor'=>8 * 1024 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['idConverter'=>18, 'discriminator'=>'zerobased', 'factor'=>8 * 1024 ** 4, 'offset'=>0]);
    }
    {
      $this->connection->insert($prefix.'Dimensions', ['idDimension'=>1, 'name'=>'Information', 'symbol'=>'Y']);
      $this->connection->insert($prefix.'Dimensions', ['idDimension'=>2, 'name'=>'Information Binary Data', 'symbol'=>'Yb']);
      $this->connection->insert($prefix.'Dimensions', ['idDimension'=>3, 'name'=>'Time', 'symbol'=>'t']);  
    }
    {
      $this->connection->insert($prefix.'UnitDimensions', ['idDimension'=>1, 'exponent'=>1]);
      $this->connection->insert($prefix.'UnitDimensions', ['idDimension'=>2, 'exponent'=>1]);
      $this->connection->insert($prefix.'UnitDimensions', ['idDimension'=>3, 'exponent'=>-1]);
    }
    {
      $this->connection->insert($prefix.'Units', ['idUnit'=>1, 'idConverter'=>1, '`key`'=>'bit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>2, 'idConverter'=>2, '`key`'=>'kilobit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>3, 'idConverter'=>3, '`key`'=>'megabit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>4, 'idConverter'=>4, '`key`'=>'gigabit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>5, 'idConverter'=>5, '`key`'=>'terabit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>6, 'idConverter'=>6, '`key`'=>'kibibit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>7, 'idConverter'=>7, '`key`'=>'mebibit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>8, 'idConverter'=>8, '`key`'=>'gibibit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>9, 'idConverter'=>9, '`key`'=>'tebibit']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>10, 'idConverter'=>10, '`key`'=>'byte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>11, 'idConverter'=>11, '`key`'=>'kilobyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>12, 'idConverter'=>12, '`key`'=>'megabyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>13, 'idConverter'=>13, '`key`'=>'gigabyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>14, 'idConverter'=>14, '`key`'=>'terabyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>15, 'idConverter'=>15, '`key`'=>'kibibyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>16, 'idConverter'=>16, '`key`'=>'mebibyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>17, 'idConverter'=>17, '`key`'=>'gibibyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>18, 'idConverter'=>18, '`key`'=>'tebibyte']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>19, 'idConverter'=>10, '`key`'=>'hertz']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>20, 'idConverter'=>11, '`key`'=>'kilohertz']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>21, 'idConverter'=>12, '`key`'=>'megahertz']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>22, 'idConverter'=>13, '`key`'=>'gigahertz']);
      $this->connection->insert($prefix.'Units', ['idUnit'=>23, 'idConverter'=>14, '`key`'=>'terahertz']);
    }
    {
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>1, 'name'=>'bit', 'symbol'=>'b', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>1, 'name'=>'bit', 'symbol'=>'b', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>1, 'name'=>'bit', 'symbol'=>'b', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>2, 'name'=>'kilobit', 'symbol'=>'kb', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>2, 'name'=>'kilobit', 'symbol'=>'kb', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>2, 'name'=>'kilobit', 'symbol'=>'kb', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>3, 'name'=>'megabit', 'symbol'=>'Mb', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>3, 'name'=>'megabit', 'symbol'=>'Mb', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>3, 'name'=>'mégabit', 'symbol'=>'Mb', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>4, 'name'=>'gigabit', 'symbol'=>'Gb', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>4, 'name'=>'gigabit', 'symbol'=>'Gb', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>4, 'name'=>'gigabit', 'symbol'=>'Gb', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>5, 'name'=>'terabit', 'symbol'=>'Tb', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>5, 'name'=>'terabit', 'symbol'=>'Tb', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>5, 'name'=>'térabit', 'symbol'=>'Tb', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>6, 'name'=>'kibibit', 'symbol'=>'Kib', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>6, 'name'=>'kibibit', 'symbol'=>'Kib', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>6, 'name'=>'kibibit', 'symbol'=>'Kib', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>7, 'name'=>'mebibit', 'symbol'=>'Mib', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>7, 'name'=>'mebibit', 'symbol'=>'Mib', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>7, 'name'=>'mébibit', 'symbol'=>'Mib', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>8, 'name'=>'gibibit', 'symbol'=>'Gib', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>8, 'name'=>'gibibit', 'symbol'=>'Gib', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>8, 'name'=>'gibibit', 'symbol'=>'Gib', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>9, 'name'=>'tebibit', 'symbol'=>'Tib', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>9, 'name'=>'tebibit', 'symbol'=>'Tib', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>9, 'name'=>'tébibit', 'symbol'=>'Tib', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>10, 'name'=>'byte', 'symbol'=>'B', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>10, 'name'=>'byte', 'symbol'=>'B', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>10, 'name'=>'byte', 'symbol'=>'B', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilobyte', 'symbol'=>'kB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilobyte', 'symbol'=>'kB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilobyte', 'symbol'=>'kB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'megabyte', 'symbol'=>'MB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'megabyte', 'symbol'=>'MB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'mégabyte', 'symbol'=>'MB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigabyte', 'symbol'=>'GB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigabyte', 'symbol'=>'GB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigabyte', 'symbol'=>'GB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'terabyte', 'symbol'=>'TB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'terabyte', 'symbol'=>'TB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'térabyte', 'symbol'=>'TB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibibyte', 'symbol'=>'KiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibibyte', 'symbol'=>'KiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibibyte', 'symbol'=>'KiB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mebibyte', 'symbol'=>'MiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mebibyte', 'symbol'=>'MiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mébibyte', 'symbol'=>'MiB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibibyte', 'symbol'=>'GiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibibyte', 'symbol'=>'GiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibibyte', 'symbol'=>'GiB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tebibyte', 'symbol'=>'TiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tebibyte', 'symbol'=>'TiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tébibyte', 'symbol'=>'TiB', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>19, 'name'=>'hertz', 'symbol'=>'Hz', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>19, 'name'=>'hertz', 'symbol'=>'Hz', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>19, 'name'=>'hertz', 'symbol'=>'Hz', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>20, 'name'=>'kilohertz', 'symbol'=>'kHz', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>20, 'name'=>'kilohertz', 'symbol'=>'kHz', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>20, 'name'=>'kilohertz', 'symbol'=>'kHz', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>21, 'name'=>'megahertz', 'symbol'=>'MHz', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>21, 'name'=>'megahertz', 'symbol'=>'MHz', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>21, 'name'=>'mégahertz', 'symbol'=>'MHz', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>22, 'name'=>'gigahertz', 'symbol'=>'GHz', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>22, 'name'=>'gigahertz', 'symbol'=>'GHz', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>22, 'name'=>'gigahertz', 'symbol'=>'GHz', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>23, 'name'=>'terahertz', 'symbol'=>'THz', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>23, 'name'=>'terahertz', 'symbol'=>'THz', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>23, 'name'=>'térahertz', 'symbol'=>'THz', 'locale'=>'fr_CA']);
    }
    {
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>1, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>2, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>3, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>4, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>5, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>6, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>7, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>8, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>9, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>10, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>11, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>12, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>13, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>14, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>15, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>16, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>17, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>18, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>19, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>20, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>21, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>22, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>23, 'idUnitDimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>19, 'idUnitDimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>20, 'idUnitDimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>21, 'idUnitDimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>22, 'idUnitDimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['idUnit'=>23, 'idUnitDimension'=>3]);
    }
  }

  private function create(Schema $schema) {
    $this->addSql('CREATE TABLE Architectures (idArchitecture BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', discriminator VARCHAR(20) NOT NULL, UNIQUE INDEX UK_Manufacturers_key (`key`), PRIMARY KEY(idArchitecture)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ArchitectureTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(10) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_34D33EA82C2AC5D3 (translatable_id), UNIQUE INDEX UK_ArchitectureTranslations_name_locale (name, locale), UNIQUE INDEX UK_ArchitectureTranslations_abbreviation_locale (abbreviation, locale), UNIQUE INDEX ArchitectureTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE GraphicAcceleratorArchitectures (idArchitecture BIGINT UNSIGNED NOT NULL, PRIMARY KEY(idArchitecture)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE HardDriveArchitectures (idArchitecture BIGINT UNSIGNED NOT NULL, PRIMARY KEY(idArchitecture)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE MemoryArchitectures (idArchitecture BIGINT UNSIGNED NOT NULL, PRIMARY KEY(idArchitecture)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ProcessorArchitectures (idArchitecture BIGINT UNSIGNED NOT NULL, PRIMARY KEY(idArchitecture)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Manufacturers (idManufacturer BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', UNIQUE INDEX UK_Manufacturers_name (name), UNIQUE INDEX UK_Manufacturers_key (`key`), PRIMARY KEY(idManufacturer)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Products (idProduct BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', idManufacturer BIGINT UNSIGNED NOT NULL, discriminator VARCHAR(20) NOT NULL, INDEX IDX_4ACC380C6394422D (idManufacturer), UNIQUE INDEX UK_Products_key (`key`), PRIMARY KEY(idProduct)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Memories (size BIGINT UNSIGNED NOT NULL, frequency BIGINT UNSIGNED NOT NULL, idProduct BIGINT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_F68AB0D3F7C0246A (size), UNIQUE INDEX UNIQ_F68AB0D3267FB813 (frequency), PRIMARY KEY(idProduct)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ProductTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A905B8A2C2AC5D3 (translatable_id), UNIQUE INDEX UK_ProductTranslations_name_locale (name, locale), UNIQUE INDEX ProductTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Scalars (idScalar BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, idUnit BIGINT UNSIGNED NOT NULL, INDEX IDX_4983DD03AF4652CD (idUnit), PRIMARY KEY(idScalar)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityConverters (idConverter BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, discriminator VARCHAR(20) NOT NULL, factor DOUBLE PRECISION DEFAULT NULL, offset DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(idConverter)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityDimensions (idDimension BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, symbol VARCHAR(5) NOT NULL, UNIQUE INDEX UK_QuantityDimensions_name (name), UNIQUE INDEX UK_QuantityDimensions_symbol (symbol), PRIMARY KEY(idDimension)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnits (idUnit BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, `key` VARCHAR(20) NOT NULL, idConverter BIGINT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_81470E8115A936BE (idConverter), UNIQUE INDEX UK_QuantityUnit_key (`key`), PRIMARY KEY(idUnit)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnits_QuantityUnitDimensions (idUnit BIGINT UNSIGNED NOT NULL, idUnitDimension BIGINT UNSIGNED NOT NULL, INDEX IDX_E5CD8525AF4652CD (idUnit), INDEX IDX_E5CD8525D970B0E3 (idUnitDimension), PRIMARY KEY(idUnit, idUnitDimension)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnitDimensions (idUnitDimension BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, exponent INT NOT NULL, idDimension BIGINT UNSIGNED NOT NULL, INDEX IDX_853940823671EACA (idDimension), UNIQUE INDEX UK_QuantityUnitDimensions_idDimension_Exponent (idDimension, exponent), PRIMARY KEY(idUnitDimension)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnitTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(50) NOT NULL, symbol VARCHAR(5) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_10C4149E2C2AC5D3 (translatable_id), UNIQUE INDEX UK_QuantityUnitTranslations_name_locale (name, locale), UNIQUE INDEX UK_QuantityUnitTranslations_symbol_locale (symbol, locale), UNIQUE INDEX QuantityUnitTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Images (idImage BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, filename VARCHAR(25) NOT NULL, idProduct BIGINT UNSIGNED NOT NULL, INDEX IDX_E7B3BB5CC3F36F5F (idProduct), UNIQUE INDEX UK_Images_filename (filename), PRIMARY KEY(idImage)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE ArchitectureTranslations ADD CONSTRAINT FK_34D33EA82C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE GraphicAcceleratorArchitectures ADD CONSTRAINT FK_19E517F92A07FA0B FOREIGN KEY (idArchitecture) REFERENCES Architectures (idArchitecture) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE HardDriveArchitectures ADD CONSTRAINT FK_9368304B2A07FA0B FOREIGN KEY (idArchitecture) REFERENCES Architectures (idArchitecture) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE MemoryArchitectures ADD CONSTRAINT FK_651165762A07FA0B FOREIGN KEY (idArchitecture) REFERENCES Architectures (idArchitecture) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE ProcessorArchitectures ADD CONSTRAINT FK_B9C6B56A2A07FA0B FOREIGN KEY (idArchitecture) REFERENCES Architectures (idArchitecture) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE Products ADD CONSTRAINT FK_4ACC380C6394422D FOREIGN KEY (idManufacturer) REFERENCES Manufacturers (idManufacturer)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D3F7C0246A FOREIGN KEY (size) REFERENCES Scalars (idScalar)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D3267FB813 FOREIGN KEY (frequency) REFERENCES Scalars (idScalar)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_F68AB0D3C3F36F5F FOREIGN KEY (idProduct) REFERENCES Products (idProduct) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE ProductTranslations ADD CONSTRAINT FK_A905B8A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Products (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE Scalars ADD CONSTRAINT FK_4983DD03AF4652CD FOREIGN KEY (idUnit) REFERENCES QuantityUnits (idUnit)');
    $this->addSql('ALTER TABLE QuantityUnits ADD CONSTRAINT FK_81470E8115A936BE FOREIGN KEY (idConverter) REFERENCES QuantityConverters (idConverter)');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions ADD CONSTRAINT FK_E5CD8525AF4652CD FOREIGN KEY (idUnit) REFERENCES QuantityUnits (idUnit)');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions ADD CONSTRAINT FK_E5CD8525D970B0E3 FOREIGN KEY (idUnitDimension) REFERENCES QuantityUnitDimensions (idUnitDimension)');
    $this->addSql('ALTER TABLE QuantityUnitDimensions ADD CONSTRAINT FK_853940823671EACA FOREIGN KEY (idDimension) REFERENCES QuantityDimensions (idDimension)');
    $this->addSql('ALTER TABLE QuantityUnitTranslations ADD CONSTRAINT FK_10C4149E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES QuantityUnits (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE Images ADD CONSTRAINT FK_E7B3BB5CC3F36F5F FOREIGN KEY (idProduct) REFERENCES Products (idProduct)');
  }

  private function drop(Schema $shema) {
    $this->addSql('ALTER TABLE ArchitectureTranslations DROP FOREIGN KEY FK_34D33EA82C2AC5D3');
    $this->addSql('ALTER TABLE GraphicAcceleratorArchitectures DROP FOREIGN KEY FK_19E517F92A07FA0B');
    $this->addSql('ALTER TABLE HardDriveArchitectures DROP FOREIGN KEY FK_9368304B2A07FA0B');
    $this->addSql('ALTER TABLE MemoryArchitectures DROP FOREIGN KEY FK_651165762A07FA0B');
    $this->addSql('ALTER TABLE ProcessorArchitectures DROP FOREIGN KEY FK_B9C6B56A2A07FA0B');
    $this->addSql('ALTER TABLE Products DROP FOREIGN KEY FK_4ACC380C6394422D');
    $this->addSql('ALTER TABLE Images DROP FOREIGN KEY FK_E7B3BB5CC3F36F5F');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D3C3F36F5F');
    $this->addSql('ALTER TABLE ProductTranslations DROP FOREIGN KEY FK_A905B8A2C2AC5D3');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D3F7C0246A');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_F68AB0D3267FB813');
    $this->addSql('ALTER TABLE QuantityUnits DROP FOREIGN KEY FK_81470E8115A936BE');
    $this->addSql('ALTER TABLE QuantityUnitDimensions DROP FOREIGN KEY FK_853940823671EACA');
    $this->addSql('ALTER TABLE Scalars DROP FOREIGN KEY FK_4983DD03AF4652CD');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions DROP FOREIGN KEY FK_E5CD8525AF4652CD');
    $this->addSql('ALTER TABLE QuantityUnitTranslations DROP FOREIGN KEY FK_10C4149E2C2AC5D3');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions DROP FOREIGN KEY FK_E5CD8525D970B0E3');
    $this->addSql('DROP TABLE Architectures');
    $this->addSql('DROP TABLE ArchitectureTranslations');
    $this->addSql('DROP TABLE GraphicAcceleratorArchitectures');
    $this->addSql('DROP TABLE HardDriveArchitectures');
    $this->addSql('DROP TABLE MemoryArchitectures');
    $this->addSql('DROP TABLE ProcessorArchitectures');
    $this->addSql('DROP TABLE Images');
    $this->addSql('DROP TABLE Manufacturers');
    $this->addSql('DROP TABLE Products');
    $this->addSql('DROP TABLE Memories');
    $this->addSql('DROP TABLE ProductTranslations');
    $this->addSql('DROP TABLE Scalars');
    $this->addSql('DROP TABLE QuantityConverters');
    $this->addSql('DROP TABLE QuantityDimensions');
    $this->addSql('DROP TABLE QuantityUnits');
    $this->addSql('DROP TABLE QuantityUnits_QuantityUnitDimensions');
    $this->addSql('DROP TABLE QuantityUnitDimensions');
    $this->addSql('DROP TABLE QuantityUnitTranslations');
  }
}
