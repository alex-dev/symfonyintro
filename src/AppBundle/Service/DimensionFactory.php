<?php
namespace AppBundle\Service;

final class DimensionFactory {
  private $mapping;

  public function __construct() {
    $this->mapping = [];
  }

  public function create(string $dimension) {
    $dimension = 'AppBundle\Type\QuantityPattern\Dimension'.$dimension;
    $this->mapping[$dimension] = new $dimension;
    return $this->mapping[$dimension];
  }
}
