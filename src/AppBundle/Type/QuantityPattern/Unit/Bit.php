<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Service\QuantityPattern\DimensionFactory;
use Service\QuantityPattern\BinaryUnitPrefixCalculator;

final class Bit extends InformationUnit {
  public function __construct(DimensionFactory $factory, BinaryUnitPrefixcalculator $prefix) {
    parent::__construct($factory, $prefix);
  }
  
  /**
   * @return string
   */
  public function getName() {
    return "unit.name.bit";
  }

  /**
   * @return string
   */
  public function getSymbol() {
    return "unit.symbol.bit";
  }

  /**
   * @return float
   */
  public function convertToBase(float $value) {
    return $value * 8;
  }

  /**
   * @return float
   */
  public function convertFromBase(float $value) {
    return $value / 8;
  }
}
