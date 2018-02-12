<?php
namespace AppBundle\Service;

use Type\QuantityPattern\Dimension\Dimension;

final class DimensionFactory extends AbstractFactory {
  private $mapping;

  public function __construct() {
    $this->mapping = [];
  }

  public function __invoke(string $dimension) {
    $dimension = "AppBundle\Type\QuantityPattern\Dimension\\$dimension";
    $this->mapping[$dimension] = new $dimension;
    return $this->mapping[$dimension];
  }

  public function find(Dimension $unit) {
    $val = array_search($unit, $this->mapping, $strict = true);

    if (!$val) {
      throw new ArgumentException("$unit was not mapped by the factory.");
    } else {
      return $val;
    }
  }
}
