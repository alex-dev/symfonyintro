<?php
namespace AppBundle\Type\QuantityPattern\Unit;

final class Byte extends InformationUnit {
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
