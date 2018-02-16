<?php
namespace AppBundle\Database;

use Doctrine\ORM\Mapping\NamingStrategy as INamingStrategy;

class NamingStrategy implements INamingStrategy {
  const quantity = 'Quantity';
  
  private $wrongPlural;
  private $quantity_prefix;

  public function __construct() {
    $this->wrongPlural = ['Memory'=>'Memories'];
    $this->quantity_prefix = [
      'Converter',
      'ZeroBasedLinearConverter',
      'OffsetLinearConverter',
      'Dimension',
      'UnitDimension',
      'Unit',
      'UnitTranslation',
      'Value',
      'Scalar'
    ];
  }

  public function classToTableName($class) {
    if (strpos($class, '\\') !== false) {
      $class = substr($class, strrpos($class, '\\') + 1);
    }

    if (in_array($class, $this->quantity_prefix)) {
      return self::quantity.$class.'s';
    } else if (isset($wrongPlural[$class])) {
      return $wrongPlural[$class];
    } else {
      return $class.'s';
    }
  }

  public function propertyToColumnName($property, $class = null) {
    return $property;
  }

  public function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null) {
    return $propertyName.'_'.$embeddedColumnName;
  }
  
  public function referenceColumnName() {
      return 'id';
  }

  public function joinColumnName($property, $class = null) {
      return $property;
  }

  public function joinTableName($source, $target, $property = null) {
      return $this->classToTableName($source).'_'.$this->classToTableName($target);
  }

  public function joinKeyColumnName($entity, $referencedColumn = null) {
      return 'FK_'.$this->classToTableName($entity).'_'.($referencedColumnName ?: $this->referenceColumnName());
  }
}
