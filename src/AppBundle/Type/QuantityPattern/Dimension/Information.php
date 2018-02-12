<?php
namespace AppBundle\Type\QuantityPattern\Dimension;

final class Information extends Dimension {
  /**
   * @return string
   */
  public function getName() {
    return "quantity.dimension.name.information";
  }

  /**
   * @return string
   */
  public function getSymbol() {
    return "quantity.dimension.symbol.information";
  }
}
