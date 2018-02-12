<?php
namespace AppBundle\Service\QuantityPattern\QuantityConverter;

use Unit\SimpleUnit;
use Unit\DerivedUnit;

final class BinaryInformationQuantityConverter extends QuantityConverter {
  private $simple;
  private $derived;

  public function __construct() {
    $this->simple = new SimpleUnit("unit.unit.bit", "symbol.unit.bit");
    $this->derived = [
      new DerivedUnit("unit.unit.byte", "symbol.unit.byte", $factor = 1 / 8)
    ];
  }

  protected function getSimple() {
    return $this->simple;
  }

  protected function getAllDerived() {
    return $this->derived;
  }
}
