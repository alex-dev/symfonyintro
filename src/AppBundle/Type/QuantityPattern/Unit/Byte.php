<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Service\QuantityPattern\DimensionFactory;
use Service\QuantityPattern\BinaryUnitPrefixCalculator;

final class Byte extends InformationUnit {
  public function __construct(DimensionFactory $factory, BinaryUnitPrefixcalculator $prefix) {
    parent::__construct($factory, $prefix);
  } 

  /**
   * @return string
   */
  public function getName() {
    return "quantity.unit.name.byte";
  }

  /**
   * @return string
   */
  public function getSymbol() {
    return "quantity.unit.symbol.byte";
  }

  /**
   * @return float
   */
  public function convertToBase(float $value) {
    return $value;
  }

  /**
   * @return float
   */
  public function convertFromBase(float $value) {
    return $value;
  }
}
