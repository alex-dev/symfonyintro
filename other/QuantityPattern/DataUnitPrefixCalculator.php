<?php
namespace AppBundle\Service\QuantityPattern;

use AppBundle\Type\QuantityPattern\Unit\UnitPrefix;

class DataUnitPrefixCalculator {
  const decimal = "decimal";
  const binary = "binary";

  private $decimal_unit;
  private $binary_unit;
  
  public function __construct() {
    $this->decimal_list = [
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
  
    $this->binary_unit = [
      new UnitPrefix("", "", 0),
      new UnitPrefix("unit.prefix.kibi", "symbol.prefix.kibi", 1024),
      new UnitPrefix("unit.prefix.mibi", "symbol.prefix.mibi", 1024 ** 2),
      new UnitPrefix("unit.prefix.gibi", "symbol.prefix.gibi", 1024 ** 3),
      new UnitPrefix("unit.prefix.tebi", "symbol.prefix.tebi", 1024 ** 4),
      new UnitPrefix("unit.prefix.pebi", "symbol.prefix.pebi", 1024 ** 5),
      new UnitPrefix("unit.prefix.exbi", "symbol.prefix.exbi", 1024 ** 6),
      new UnitPrefix("unit.prefix.zebi", "symbol.prefix.zebi", 1024 ** 7),
      new UnitPrefix("unit.prefix.yobi", "symbol.prefix.yobi", 1024 ** 8)    
    ];
  }

  /**
   * @return UnitPrefix
   */
  public function __invoke(float $value, $mode=self::decimal) {
    switch ($mode) {
      case self::decimal:
        return $this->getClosestDecimalUnit($value);
      case self::binary:
        return $this->getClosestBinaryUnit($value);
      default:
        throw new LogicException("$mode is not a valid value.");
    }
  }

  private function getClosestDecimalUnit(float $value) {
    $unitLength = count($this->decimal_unit);
    $unitIndex = 6;
    $increment = $value > 1 ? 1 : -1;
    $variation = $value > 1 ? 'self::isReduced' : 'self::isIncreased';

    while ($unitIndex >= 0 && $unitIndex < $unitLength
      && !$variation($value, $this->decimal_unit[$unitIndex])) {
      $unitIndex += $increment;
    }

    return $this->decimal_unit[$unitIndex];
  }

  private function getClosestBinaryUnit(float $value) {
    $unitLength = count($this->binary_unit);
    $unitIndex = 0;

    while ($unitIndex < $unitLength
      && !self::isReduced($value, $this->binary_unit[$unitIndex])) {
      ++$unitIndex;
    }

    return $this->binary_unit[$unitIndex];
  }

  private static function isReduced(float $value, UnitPrefix $unit) {
    return $value / $unit.getFactor() < 1000;
  }

  private static function isIncreased(float $value, UnitPrefix $unit) {
    return $value / $unit.getFactor() > 0.0001;
  }
}