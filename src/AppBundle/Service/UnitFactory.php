<?php
namespace AppBundle\Service;

final class UnitFactory {
  private $mapping;

  public function __construct() {
    $this->mapping = [];
  }

  public function create(string $unit) {
    $unit = 'AppBundle\Type\QuantityPattern\Dimension'.$unit;
    $this->mapping[$unit] = new $unit;
    return $this->mapping[$unit];
  }
}
