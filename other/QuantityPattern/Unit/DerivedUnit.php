<?php
namespace AppBundle\Type\QuantityPattern\Unit;

final class DerivedUnit extends BaseUnit {
  private $factor;
  private $offset;

  public function __construct(string $internal, string $name, string $symbol, $factor = 1, $offset = 0) {
    parent::__construct($internal, $name, $symbol);
    $this->factor = $factor;
    $this->offset = $offset;
  }

  /**
   * @return float
   */
  public function convertToBaseUnit(float $value) {
    return ($value - $offset) / $factor;
  }

  /**
   * @return float
   */
  public function convertFromBaseUnit(float $value) {
    return $value * $factor + $offset;
  }
}
