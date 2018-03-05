<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use AppBundle\Type\UUID;

class Version20180215214238 extends AbstractMigration
{

  public function up(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->create($schema);
  }

  /** Make sure uuid are working. */
  public function preUp(Schema $schema) {
    $type = UUID::create();
    $copyHex = UUID::createFromHex($type->toHex());
    $copyStr = UUID::createFromString($type);
    echo gettype($type), ': ', $type, ' ', $type->toHex(), PHP_EOL;
    echo gettype($copyHex), ': ', $copyHex, ' ', $copyHex->toHex(), PHP_EOL;
    echo gettype($copyStr), ': ', $copyStr, ' ', $copyStr->toHex(), PHP_EOL;
    echo $type == $copyHex ? 'Ok' : 'Fail', ' ', $type == $copyStr ? 'Ok' : 'Fail', PHP_EOL;

    $simple = UUID::create()->toHex();
    echo gettype($simple), ': ', $simple, PHP_EOL;

    $complex = [
      'id'=>1,
      'discriminator'=>'memory',
      'manufacturer'=>1,
      'code'=>'BLS4G4D240FSC',
      '`key`'=>UUID::create()->toHex()
    ];
    echo gettype($complex['`key`']), ': ', $complex['`key`'], PHP_EOL;
  }

  public function postUp(Schema $schema) {
    $this->connection->setautoCommit(false);
    $this->insertUnits($schema);
    $this->insertScalars($schema);
    $this->insertArchitectures($schema);
    $this->insertManufacturers($schema);
    $this->insertProducts($schema);
    $this->insertImages($schema);
  }

  public function down(Schema $schema)
  {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->drop($schema);
  }

  private function insertImages(Schema $schema) {
    $this->connection->insert('Images', ['product'=>1, 'filename'=>'EQXceR6SbkeuxmHoWLGV8w']);
    $this->connection->insert('Images', ['product'=>2, 'filename'=>'fzhMtWnZwUOGWvpAKsJg0w']);
    $this->connection->insert('Images', ['product'=>3, 'filename'=>'fE84dKQy5kSoMaLYwEForg']);
    $this->connection->insert('Images', ['product'=>4, 'filename'=>'SifDZOSKW0KOpuI8hSbpiQ']);
    $this->connection->insert('Images', ['product'=>5, 'filename'=>'vtkY7ptMhUeszkC8cIj52A']);
    $this->connection->insert('Images', ['product'=>6, 'filename'=>'t8mNCuagPkWYEHUWFASQng']);
    $this->connection->insert('Images', ['product'=>7, 'filename'=>'8ja4d8KbbEiOoYojH0Q9OA']);
    $this->connection->insert('Images', ['product'=>8, 'filename'=>'etYPkTgkUkuh21kIvTZFZQ']);
    $this->connection->insert('Images', ['product'=>9, 'filename'=>'cKfW3HEZhEaslleyCzYMGQ']);
    $this->connection->insert('Images', ['product'=>10, 'filename'=>'vGUupMJA60mUkBoTLg2Dmw']);
    $this->connection->insert('Images', ['product'=>11, 'filename'=>'9Z1OTApEAE6LjRD4vwTOqw']);
    $this->connection->insert('Images', ['product'=>12, 'filename'=>'P3oWuWWnyEO0WaPubvZROg']);
    $this->connection->insert('Images', ['product'=>13, 'filename'=>'CfLNI71S4ECXCTqYo6X3wA']);
    $this->connection->insert('Images', ['product'=>14, 'filename'=>'LxNSOolmvka240VWvdfeOw']);
    $this->connection->insert('Images', ['product'=>15, 'filename'=>'mQZilOE1EEuX6enaKIceGg']);
  }

  private function insertProducts(Schema $schema) {
    {
      $this->connection->insert('Products', ['id'=>1, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLS4G4D240FSC','`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>2, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT4G4DFS824A', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>3, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLS4G4D240FSE', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>4, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLS4G4D240FSB', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>5, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLT4G4D26AFTA', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>6, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT102464BD160B', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>7, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT51264BD186DJ', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>8, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT102464BD186D', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>9, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLT4G3D1608DT1TX0', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>10, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'BLS4G3D1609DS1S00', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>11, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT51264BD160B', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>12, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT12864AA667', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>13, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT12864AA800', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>14, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT25664AA667', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert('Products', ['id'=>15, 'discriminator'=>'memory', 'manufacturer'=>1, 'code'=>'CT25664AA800', '`key`'=>UUID::create()->toHex()]);
    } 
    {
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT White 4GB DDR4-2400 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT White 4GB DDR4-2400 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>1, 'name'=>'Ballistix Sport LT Blanc 4GB DDR4-2400 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>2, 'name'=>'Crucial 4GB DDR4-2400 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>2, 'name'=>'Crucial 4GB DDR4-2400 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>2, 'name'=>'Crucial 4GB DDR4-2400 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>3, 'name'=>'Ballistix Sport LT Red 4GB DDR4-2400 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>3, 'name'=>'Ballistix Sport LT Red 4GB DDR4-2400 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>3, 'name'=>'Ballistix Sport LT Rouge 4GB DDR4-2400 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>4, 'name'=>'Ballistix Sport LT Gray 4GB DDR4-2400 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>4, 'name'=>'Ballistix Sport LT Gray 4GB DDR4-2400 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>4, 'name'=>'Ballistix Sport LT Gris 4GB DDR4-2400 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>5, 'name'=>'Ballistix Tactical 4GB DDR4-2666 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>5, 'name'=>'Ballistix Tactical 4GB DDR4-2666 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>5, 'name'=>'Ballistix Tactical 4GB DDR4-2666 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>6, 'name'=>'Crucial 8GB DDR3L-1600 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>6, 'name'=>'Crucial 8GB DDR3L-1600 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>6, 'name'=>'Crucial 8GB DDR3L-1600 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>7, 'name'=>'Crucial 4GB DDR3L-1866 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>7, 'name'=>'Crucial 4GB DDR3L-1866 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>7, 'name'=>'Crucial 4GB DDR3L-1866 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>8, 'name'=>'Crucial 8GB DDR3-1866 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>8, 'name'=>'Crucial 8GB DDR3-1866 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>8, 'name'=>'Crucial 8GB DDR3-1866 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>9, 'name'=>'Ballistix Tactical 4GB DDR3-1600 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>9, 'name'=>'Ballistix Tactical 4GB DDR3-1600 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>9, 'name'=>'Ballistix Tactical 4GB DDR3-1600 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>10, 'name'=>'Ballistix Sport 4GB DDR3-1600 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>10, 'name'=>'Ballistix Sport 4GB DDR3-1600 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>10, 'name'=>'Ballistix Sport 4GB DDR3-1600 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>11, 'name'=>'Crucial 4GB DDR3L-1600 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>11, 'name'=>'Crucial 4GB DDR3L-1600 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>11, 'name'=>'Crucial 4GB DDR3L-1600 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>12, 'name'=>'Crucial 1GB DDR2-667 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>12, 'name'=>'Crucial 1GB DDR2-667 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>12, 'name'=>'Crucial 1GB DDR2-667 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>13, 'name'=>'Crucial 1GB DDR2-800 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>13, 'name'=>'Crucial 1GB DDR2-800 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>13, 'name'=>'Crucial 1GB DDR2-800 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>14, 'name'=>'Crucial 2GB DDR2-666 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>14, 'name'=>'Crucial 2GB DDR2-666 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>14, 'name'=>'Crucial 2GB DDR2-666 UDIMM', 'locale'=>'fr_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>15, 'name'=>'Crucial 2GB DDR2-800 UDIMM', 'locale'=>'en_US']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>15, 'name'=>'Crucial 2GB DDR2-800 UDIMM', 'locale'=>'en_CA']);
      $this->connection->insert('ProductTranslations', ['translatable_id'=>15, 'name'=>'Crucial 2GB DDR2-800 UDIMM', 'locale'=>'fr_CA']); 
    }
    {
      $this->connection->insert('Memories', ['id'=>1, 'architecture'=>1, 'size'=>1, 'frequency'=>2]);
      $this->connection->insert('Memories', ['id'=>2, 'architecture'=>1, 'size'=>3, 'frequency'=>4]);
      $this->connection->insert('Memories', ['id'=>3, 'architecture'=>1, 'size'=>5, 'frequency'=>6]);
      $this->connection->insert('Memories', ['id'=>4, 'architecture'=>1, 'size'=>7, 'frequency'=>8]);
      $this->connection->insert('Memories', ['id'=>5, 'architecture'=>1, 'size'=>9, 'frequency'=>10]);
      $this->connection->insert('Memories', ['id'=>6, 'architecture'=>2, 'size'=>11, 'frequency'=>12]);
      $this->connection->insert('Memories', ['id'=>7, 'architecture'=>2, 'size'=>13, 'frequency'=>14]);
      $this->connection->insert('Memories', ['id'=>8, 'architecture'=>2, 'size'=>15, 'frequency'=>16]);
      $this->connection->insert('Memories', ['id'=>9, 'architecture'=>2, 'size'=>17, 'frequency'=>18]);
      $this->connection->insert('Memories', ['id'=>10, 'architecture'=>2, 'size'=>19, 'frequency'=>20]);
      $this->connection->insert('Memories', ['id'=>11, 'architecture'=>2, 'size'=>21, 'frequency'=>22]);
      $this->connection->insert('Memories', ['id'=>12, 'architecture'=>3, 'size'=>23, 'frequency'=>24]);
      $this->connection->insert('Memories', ['id'=>13, 'architecture'=>3, 'size'=>25, 'frequency'=>26]);
      $this->connection->insert('Memories', ['id'=>14, 'architecture'=>3, 'size'=>27, 'frequency'=>28]);
      $this->connection->insert('Memories', ['id'=>15, 'architecture'=>3, 'size'=>29, 'frequency'=>30]);
    }
  }

  private function insertManufacturers(Schema $schema) {
    $this->connection->insert('Manufacturers', ['id'=>1, 'name'=>'Crucial', '`key`'=>UUID::create()->toHex()]);
  }

  private function insertArchitectures(Schema $schema) {
    $prefix = 'Architecture';

    {
      $this->connection->insert($prefix.'s', ['id'=>1, 'discriminator'=>'memoryarchitecture', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert($prefix.'s', ['id'=>2, 'discriminator'=>'memoryarchitecture', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert($prefix.'s', ['id'=>3, 'discriminator'=>'memoryarchitecture', '`key`'=>UUID::create()->toHex()]);
    }
    {
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>1, 'name'=>'DDR4', 'abbreviation'=>'DDR4', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3', 'abbreviation'=>'DDR3', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3', 'abbreviation'=>'DDR3', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>2, 'name'=>'DDR3', 'abbreviation'=>'DDR3', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR2', 'abbreviation'=>'DDR2', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR2', 'abbreviation'=>'DDR2', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>3, 'name'=>'DDR2', 'abbreviation'=>'DDR2', 'locale'=>'fr_CA']);
    }
    {
      $this->connection->insert('Memory'.$prefix.'s', ['id'=>1]);
      $this->connection->insert('Memory'.$prefix.'s', ['id'=>2]);
      $this->connection->insert('Memory'.$prefix.'s', ['id'=>3]);
    }
  }

  private function insertScalars(Schema $schema) {
    $prefix = 'Quantity';

    $this->connection->insert($prefix.'Scalars', ['id'=>1, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>2, 'unit'=>21, 'value'=>2400]);
    $this->connection->insert($prefix.'Scalars', ['id'=>3, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>4, 'unit'=>21, 'value'=>2400]);
    $this->connection->insert($prefix.'Scalars', ['id'=>5, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>6, 'unit'=>21, 'value'=>2400]);
    $this->connection->insert($prefix.'Scalars', ['id'=>7, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>8, 'unit'=>21, 'value'=>2400]);
    $this->connection->insert($prefix.'Scalars', ['id'=>9, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>10, 'unit'=>21, 'value'=>2666]);
    $this->connection->insert($prefix.'Scalars', ['id'=>11, 'unit'=>13, 'value'=>8]);
    $this->connection->insert($prefix.'Scalars', ['id'=>12, 'unit'=>21, 'value'=>1600]);
    $this->connection->insert($prefix.'Scalars', ['id'=>13, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>14, 'unit'=>21, 'value'=>1866]);
    $this->connection->insert($prefix.'Scalars', ['id'=>15, 'unit'=>13, 'value'=>8]);
    $this->connection->insert($prefix.'Scalars', ['id'=>16, 'unit'=>21, 'value'=>1866]);
    $this->connection->insert($prefix.'Scalars', ['id'=>17, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>18, 'unit'=>21, 'value'=>1600]);
    $this->connection->insert($prefix.'Scalars', ['id'=>19, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>20, 'unit'=>21, 'value'=>1600]);
    $this->connection->insert($prefix.'Scalars', ['id'=>21, 'unit'=>13, 'value'=>4]);
    $this->connection->insert($prefix.'Scalars', ['id'=>22, 'unit'=>21, 'value'=>1600]);
    $this->connection->insert($prefix.'Scalars', ['id'=>23, 'unit'=>13, 'value'=>1]);
    $this->connection->insert($prefix.'Scalars', ['id'=>24, 'unit'=>21, 'value'=>667]);
    $this->connection->insert($prefix.'Scalars', ['id'=>25, 'unit'=>13, 'value'=>1]);
    $this->connection->insert($prefix.'Scalars', ['id'=>26, 'unit'=>21, 'value'=>800]);
    $this->connection->insert($prefix.'Scalars', ['id'=>27, 'unit'=>13, 'value'=>2]);
    $this->connection->insert($prefix.'Scalars', ['id'=>28, 'unit'=>21, 'value'=>666]);
    $this->connection->insert($prefix.'Scalars', ['id'=>29, 'unit'=>13, 'value'=>2]);
    $this->connection->insert($prefix.'Scalars', ['id'=>30, 'unit'=>21, 'value'=>800]);
  }

  private function insertUnits(Schema $schema) {
    $prefix = 'Quantity';

    {
      $this->connection->insert($prefix.'Converters', ['id'=>1, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>1, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>2, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>10 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>3, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>10 ** 6, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>4, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>10 ** 9, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>5, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>10 ** 12, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>6, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>1024, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>7, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>1024 ** 2, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>8, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>1024 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>9, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>1024 ** 4, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>10, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>11, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 10 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>12, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 10 ** 6, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>13, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 10 ** 9, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>14, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 10 ** 12, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>15, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 1024, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>16, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 1024 ** 2, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>17, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 1024 ** 3, 'offset'=>0]);
      $this->connection->insert($prefix.'Converters', ['id'=>18, 'discriminator'=>'zerobasedlinearconverter', 'factor'=>8 * 1024 ** 4, 'offset'=>0]);
    }
    {
      $this->connection->insert($prefix.'Dimensions', ['id'=>1, 'name'=>'Information', 'symbol'=>'Y']);
      $this->connection->insert($prefix.'Dimensions', ['id'=>2, 'name'=>'Information Binary Data', 'symbol'=>'Yb']);
      $this->connection->insert($prefix.'Dimensions', ['id'=>3, 'name'=>'Time', 'symbol'=>'t']);  
    }
    {
      $this->connection->insert($prefix.'UnitDimensions', ['id'=>1, 'dimension'=>1, 'exponent'=>1]);
      $this->connection->insert($prefix.'UnitDimensions', ['id'=>2, 'dimension'=>2, 'exponent'=>1]);
      $this->connection->insert($prefix.'UnitDimensions', ['id'=>3, 'dimension'=>3, 'exponent'=>-1]);
    }
    {
      $this->connection->insert($prefix.'Units', ['id'=>1, 'converter'=>1, '`key`'=>'bit']);
      $this->connection->insert($prefix.'Units', ['id'=>2, 'converter'=>2, '`key`'=>'kilobit']);
      $this->connection->insert($prefix.'Units', ['id'=>3, 'converter'=>3, '`key`'=>'megabit']);
      $this->connection->insert($prefix.'Units', ['id'=>4, 'converter'=>4, '`key`'=>'gigabit']);
      $this->connection->insert($prefix.'Units', ['id'=>5, 'converter'=>5, '`key`'=>'terabit']);
      $this->connection->insert($prefix.'Units', ['id'=>6, 'converter'=>6, '`key`'=>'kibibit']);
      $this->connection->insert($prefix.'Units', ['id'=>7, 'converter'=>7, '`key`'=>'mebibit']);
      $this->connection->insert($prefix.'Units', ['id'=>8, 'converter'=>8, '`key`'=>'gibibit']);
      $this->connection->insert($prefix.'Units', ['id'=>9, 'converter'=>9, '`key`'=>'tebibit']);
      $this->connection->insert($prefix.'Units', ['id'=>10, 'converter'=>10, '`key`'=>'byte']);
      $this->connection->insert($prefix.'Units', ['id'=>11, 'converter'=>11, '`key`'=>'kilobyte']);
      $this->connection->insert($prefix.'Units', ['id'=>12, 'converter'=>12, '`key`'=>'megabyte']);
      $this->connection->insert($prefix.'Units', ['id'=>13, 'converter'=>13, '`key`'=>'gigabyte']);
      $this->connection->insert($prefix.'Units', ['id'=>14, 'converter'=>14, '`key`'=>'terabyte']);
      $this->connection->insert($prefix.'Units', ['id'=>15, 'converter'=>15, '`key`'=>'kibibyte']);
      $this->connection->insert($prefix.'Units', ['id'=>16, 'converter'=>16, '`key`'=>'mebibyte']);
      $this->connection->insert($prefix.'Units', ['id'=>17, 'converter'=>17, '`key`'=>'gibibyte']);
      $this->connection->insert($prefix.'Units', ['id'=>18, 'converter'=>18, '`key`'=>'tebibyte']);
      $this->connection->insert($prefix.'Units', ['id'=>19, 'converter'=>1, '`key`'=>'hertz']);
      $this->connection->insert($prefix.'Units', ['id'=>20, 'converter'=>2, '`key`'=>'kilohertz']);
      $this->connection->insert($prefix.'Units', ['id'=>21, 'converter'=>3, '`key`'=>'megahertz']);
      $this->connection->insert($prefix.'Units', ['id'=>22, 'converter'=>4, '`key`'=>'gigahertz']);
      $this->connection->insert($prefix.'Units', ['id'=>23, 'converter'=>5, '`key`'=>'terahertz']);
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
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>10, 'name'=>'octet', 'symbol'=>'o', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilobyte', 'symbol'=>'kB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilobyte', 'symbol'=>'kB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>11, 'name'=>'kilooctet', 'symbol'=>'ko', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'megabyte', 'symbol'=>'MB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'megabyte', 'symbol'=>'MB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>12, 'name'=>'mégaoctet', 'symbol'=>'Mo', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigabyte', 'symbol'=>'GB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigabyte', 'symbol'=>'GB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>13, 'name'=>'gigaoctet', 'symbol'=>'Go', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'terabyte', 'symbol'=>'TB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'terabyte', 'symbol'=>'TB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>14, 'name'=>'téraoctet', 'symbol'=>'To', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibibyte', 'symbol'=>'KiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibibyte', 'symbol'=>'KiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>15, 'name'=>'kibioctet', 'symbol'=>'Kio', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mebibyte', 'symbol'=>'MiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mebibyte', 'symbol'=>'MiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>16, 'name'=>'mébioctet', 'symbol'=>'Mio', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibibyte', 'symbol'=>'GiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibibyte', 'symbol'=>'GiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>17, 'name'=>'gibioctet', 'symbol'=>'Gio', 'locale'=>'fr_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tebibyte', 'symbol'=>'TiB', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tebibyte', 'symbol'=>'TiB', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'UnitTranslations', ['translatable_id'=>18, 'name'=>'tébioctet', 'symbol'=>'Tio', 'locale'=>'fr_CA']);
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
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>1, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>2, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>3, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>4, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>5, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>6, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>7, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>8, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>9, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>10, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>11, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>12, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>13, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>14, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>15, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>16, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>17, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>18, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>19, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>20, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>21, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>22, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>23, 'dimension'=>2]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>19, 'dimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>20, 'dimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>21, 'dimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>22, 'dimension'=>3]);
      $this->connection->insert($prefix.'Units_'.$prefix.'UnitDimensions', ['unit'=>23, 'dimension'=>3]);
    }
  }

  private function create(Schema $schema) {
    $this->addSql('CREATE TABLE Architectures (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', discriminator VARCHAR(50) NOT NULL, UNIQUE INDEX UK_Architectures_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ArchitectureTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(10) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_34D33EA82C2AC5D3 (translatable_id), UNIQUE INDEX UK_ArchitectureTranslations_name_locale (name, locale), UNIQUE INDEX ArchitectureTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE GraphicAcceleratorArchitectures (id BIGINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE HardDriveArchitectures (id BIGINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE MemoryArchitectures (id BIGINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ProcessorArchitectures (id BIGINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Images (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, product BIGINT UNSIGNED NOT NULL, filename VARCHAR(25) NOT NULL, INDEX IDX_E7B3BB5CD34A04AD (product), UNIQUE INDEX UK_Images_filename (filename), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Manufacturers (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', UNIQUE INDEX UK_Manufacturers_name (name), UNIQUE INDEX UK_Manufacturers_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Products (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, manufacturer BIGINT UNSIGNED NOT NULL, code VARCHAR(50) NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', discriminator VARCHAR(50) NOT NULL, INDEX IDX_4ACC380C3D0AE6DC (manufacturer), UNIQUE INDEX UK_Products_key (`key`), UNIQUE INDEX UK_Products_code_manufacturer (code, manufacturer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Memories (id BIGINT UNSIGNED NOT NULL, size BIGINT UNSIGNED NOT NULL, frequency BIGINT UNSIGNED NOT NULL, architecture BIGINT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_82EA5F80F7C0246A (size), UNIQUE INDEX UNIQ_82EA5F80267FB813 (frequency), INDEX IDX_82EA5F8074995EFA (architecture), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE ProductTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A905B8A2C2AC5D3 (translatable_id), UNIQUE INDEX ProductTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityScalars (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, unit BIGINT UNSIGNED NOT NULL, value DOUBLE PRECISION NOT NULL, INDEX IDX_35CD490CDCBB0C53 (unit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityConverters (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, discriminator VARCHAR(50) NOT NULL, factor DOUBLE PRECISION DEFAULT NULL, offset DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityDimensions (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, symbol VARCHAR(5) BINARY NOT NULL COMMENT \'(DC2Type:string_sensitive)\', UNIQUE INDEX UK_QuantityDimensions_name (name), UNIQUE INDEX UK_QuantityDimensions_symbol (symbol), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnits (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, converter BIGINT UNSIGNED NOT NULL, `key` VARCHAR(20) NOT NULL, INDEX IDX_81470E81E9431DE8 (converter), UNIQUE INDEX UK_QuantityUnit_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnits_QuantityUnitDimensions (unit BIGINT UNSIGNED NOT NULL, dimension BIGINT UNSIGNED NOT NULL, INDEX IDX_E5CD8525DCBB0C53 (unit), INDEX IDX_E5CD8525CA9BC19C (dimension), PRIMARY KEY(unit, dimension)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnitDimensions (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, dimension BIGINT UNSIGNED NOT NULL, exponent INT NOT NULL, INDEX IDX_85394082CA9BC19C (dimension), UNIQUE INDEX UK_QuantityUnitDimensions_dimension_exponent (dimension, exponent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE QuantityUnitTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(50) NOT NULL, symbol VARCHAR(5) BINARY NOT NULL COMMENT \'(DC2Type:string_sensitive)\', locale VARCHAR(255) NOT NULL, INDEX IDX_10C4149E2C2AC5D3 (translatable_id), UNIQUE INDEX UK_QuantityUnitTranslations_name_locale (name, locale), UNIQUE INDEX UK_QuantityUnitTranslations_symbol_locale (symbol, locale), UNIQUE INDEX QuantityUnitTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE ArchitectureTranslations ADD CONSTRAINT FK_34D33EA82C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE GraphicAcceleratorArchitectures ADD CONSTRAINT FK_19E517F9BF396750 FOREIGN KEY (id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE HardDriveArchitectures ADD CONSTRAINT FK_9368304BBF396750 FOREIGN KEY (id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE MemoryArchitectures ADD CONSTRAINT FK_65116576BF396750 FOREIGN KEY (id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE ProcessorArchitectures ADD CONSTRAINT FK_B9C6B56ABF396750 FOREIGN KEY (id) REFERENCES Architectures (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE Images ADD CONSTRAINT FK_E7B3BB5CD34A04AD FOREIGN KEY (product) REFERENCES Products (id)');
    $this->addSql('ALTER TABLE Products ADD CONSTRAINT FK_4ACC380C3D0AE6DC FOREIGN KEY (manufacturer) REFERENCES Manufacturers (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_82EA5F80F7C0246A FOREIGN KEY (size) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_82EA5F80267FB813 FOREIGN KEY (frequency) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_82EA5F8074995EFA FOREIGN KEY (architecture) REFERENCES MemoryArchitectures (id)');
    $this->addSql('ALTER TABLE Memories ADD CONSTRAINT FK_82EA5F80BF396750 FOREIGN KEY (id) REFERENCES Products (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE ProductTranslations ADD CONSTRAINT FK_A905B8A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Products (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE QuantityScalars ADD CONSTRAINT FK_35CD490CDCBB0C53 FOREIGN KEY (unit) REFERENCES QuantityUnits (id)');
    $this->addSql('ALTER TABLE QuantityUnits ADD CONSTRAINT FK_81470E81E9431DE8 FOREIGN KEY (converter) REFERENCES QuantityConverters (id)');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions ADD CONSTRAINT FK_E5CD8525DCBB0C53 FOREIGN KEY (unit) REFERENCES QuantityUnits (id)');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions ADD CONSTRAINT FK_E5CD8525CA9BC19C FOREIGN KEY (dimension) REFERENCES QuantityUnitDimensions (id)');
    $this->addSql('ALTER TABLE QuantityUnitDimensions ADD CONSTRAINT FK_85394082CA9BC19C FOREIGN KEY (dimension) REFERENCES QuantityDimensions (id)');
    $this->addSql('ALTER TABLE QuantityUnitTranslations ADD CONSTRAINT FK_10C4149E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES QuantityUnits (id) ON DELETE CASCADE');
  }

  private function drop(Schema $schema) {
    $this->addSql('ALTER TABLE ArchitectureTranslations DROP FOREIGN KEY FK_34D33EA82C2AC5D3');
    $this->addSql('ALTER TABLE GraphicAcceleratorArchitectures DROP FOREIGN KEY FK_19E517F9BF396750');
    $this->addSql('ALTER TABLE HardDriveArchitectures DROP FOREIGN KEY FK_9368304BBF396750');
    $this->addSql('ALTER TABLE MemoryArchitectures DROP FOREIGN KEY FK_65116576BF396750');
    $this->addSql('ALTER TABLE ProcessorArchitectures DROP FOREIGN KEY FK_B9C6B56ABF396750');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_82EA5F8074995EFA');
    $this->addSql('ALTER TABLE Products DROP FOREIGN KEY FK_4ACC380C3D0AE6DC');
    $this->addSql('ALTER TABLE Images DROP FOREIGN KEY FK_E7B3BB5CD34A04AD');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_82EA5F80BF396750');
    $this->addSql('ALTER TABLE ProductTranslations DROP FOREIGN KEY FK_A905B8A2C2AC5D3');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_82EA5F80F7C0246A');
    $this->addSql('ALTER TABLE Memories DROP FOREIGN KEY FK_82EA5F80267FB813');
    $this->addSql('ALTER TABLE QuantityUnits DROP FOREIGN KEY FK_81470E81E9431DE8');
    $this->addSql('ALTER TABLE QuantityUnitDimensions DROP FOREIGN KEY FK_85394082CA9BC19C');
    $this->addSql('ALTER TABLE QuantityScalars DROP FOREIGN KEY FK_35CD490CDCBB0C53');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions DROP FOREIGN KEY FK_E5CD8525DCBB0C53');
    $this->addSql('ALTER TABLE QuantityUnitTranslations DROP FOREIGN KEY FK_10C4149E2C2AC5D3');
    $this->addSql('ALTER TABLE QuantityUnits_QuantityUnitDimensions DROP FOREIGN KEY FK_E5CD8525CA9BC19C');
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
    $this->addSql('DROP TABLE QuantityScalars');
    $this->addSql('DROP TABLE QuantityConverters');
    $this->addSql('DROP TABLE QuantityDimensions');
    $this->addSql('DROP TABLE QuantityUnits');
    $this->addSql('DROP TABLE QuantityUnits_QuantityUnitDimensions');
    $this->addSql('DROP TABLE QuantityUnitDimensions');
    $this->addSql('DROP TABLE QuantityUnitTranslations');
  }
}
