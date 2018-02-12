<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Dimension\Dimension;

abstract class Unit {
  private $dimensions;

  public function __construct(array $dimensions) {
    $this->dimensions = $dimensions;
  }

  /**
   * @return array<Pair<Dimension>, exponent>
   */
  public function getDimensions() {
    return $this->dimensions;
  }
  
  /**
   * @return boolean
   */
  public function isConvertible(Unit $to) {
    return $this->getDimensions() == $to->getDimensions();
  }

  /**
   * @return float
   */
  public function convert(Unit $to, float $value) {
    if (!$this->unit->isConvertible($unit)) {
      throw new UnitException("$this->getUnit() is not convertible to $unit.");
    } else {
      return $to->convertFromBase($this->convertToBase($value));
    }
  }

  /**
   * @return string
   */
  abstract public function getName();

  /**
   * @return string
   */
  abstract public function getSymbol();

  /**
   * @return float
   */
  abstract protected function convertToBase(float $value);

  /**
   * @return float
   */
  abstract protected function convertFromBase(float $value);
}
