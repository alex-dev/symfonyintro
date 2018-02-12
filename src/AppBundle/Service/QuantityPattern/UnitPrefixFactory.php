<?php
namespace AppBundle\Service;

use Type\QuantityPattern\UnitPrefix\UnitPrefix;

abstract class UnitPrefixFactory extends AbstractFactory {
  protected $mapping;

  public function __invoke(string $unit) {
    $val = $this->mapping[$unit];

    if (!$val) {
      throw new ArgumentException("$unit is not mapped by the factory.");
    } else {
      return $val;
    }
  }

  public function find($unit) {
    $val = array_search($unit, $this->mapping, $strict = true);

    if (!$val) {
      throw new ArgumentException("$unit was not mapped by the factory.");
    } else {
      return $val;
    }
  }
}
