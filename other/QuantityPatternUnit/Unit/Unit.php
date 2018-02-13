<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Exception\UnitException;
use Service\QuantityPattern\AbstractUnitPrefixCalculator;
use Dimension\Dimension;

abstract class Unit {
  private $prefix;
  private $dimensions;

  public function __construct(array $dimensions, AbstractUnitPrefixcalculator $prefix) {
    $this->dimensions = $dimensions;
    $this->prefix;
  }

  /**
   * @return array<Pair<Dimension>, exponent>
   */
  public function getDimensions() {
    return $this->dimensions;
  }

  /**
   * @return UnitPrefix
   */
  public function getPrefix(float $value) {
    return $this->prefix($value);
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
