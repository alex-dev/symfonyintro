<?php
namespace AppBundle\Service;

use Type\QuantityPattern\Unit\Unit;

final class UnitFactory extends AbstractFactory {
  private $mapping;

  public function __construct() {
    $this->mapping = [];
  }

  public function __invoke(string $unit) {
    $unit = "AppBundle\Type\QuantityPattern\Dimension\\$unit";
    $this->mapping[$unit] = new $unit;
    return $this->mapping[$unit];
  }

  public function find(Unit $unit) {
    $val = array_search($unit, $this->mapping, $strict = true);

    if (!$val) {
      throw new ArgumentException("$unit was not mapped by the factory.");
    } else {
      return $val;
    }
  }
}
