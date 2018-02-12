<?php
namespace AppBundle\Service\QuantityPattern;

use AppBundle\Type\QuantityPattern\Unit\UnitPrefix;

class DataUnitPrefixCalculator {
  private $unit;
  private $startIndex;
  
  public function __construct() {
    $this->unit = [
      new UnitPrefix("unit.prefix.exa", "symbol.prefix.exa", 10 ** 18),
      new UnitPrefix("unit.prefix.peta", "symbol.prefix.peta", 10 ** 15),
      new UnitPrefix("unit.prefix.tera", "symbol.prefix.tera", 10 ** 12),
      new UnitPrefix("unit.prefix.giga", "symbol.prefix.giga", 10 ** 9),
      new UnitPrefix("unit.prefix.mega", "symbol.prefix.mega", 10 ** 6),
      new UnitPrefix("unit.prefix.kilo", "symbol.prefix.kilo", 10 ** 3),
      new UnitPrefix("", "", 0),
      new UnitPrefix("unit.prefix.milli", "symbol.prefix.milli", 10 ** -3),
      new UnitPrefix("unit.prefix.micro", "symbol.prefix.micro", 10 ** -6),
      new UnitPrefix("unit.prefix.nano", "symbol.prefix.nano", 10 ** -9),
      new UnitPrefix("unit.prefix.pico", "symbol.prefix.pico", 10 ** -12),
      new UnitPrefix("unit.prefix.femto", "symbol.prefix.femto", 10 ** -15),
      new UnitPrefix("unit.prefix.atto", "symbol.prefix.atto", 10 ** -18)
    ];

    $this->startIndex = 6;
  }

  /**
   * @return UnitPrefix
   */
  public function __invoke(float $value) {
    $unitLength = count($this->decimal_unit);
    $unitIndex = $this->startIndex;
    $increment = $value > 1 ? 1 : -1;
    $variation = $value > 1 ? 'parent::isReduced' : 'parent::isIncreased';

    while ($unitIndex >= 0 && $unitIndex < $unitLength
      && !$variation($value, $this->unit[$unitIndex])) {
      $unitIndex += $increment;
    }

    return $this->unit[$unitIndex];
  }
}