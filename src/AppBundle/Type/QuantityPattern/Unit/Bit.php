<?php
namespace AppBundle\Type\QuantityPattern\Unit;

final class Bit extends InformationUnit {
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
