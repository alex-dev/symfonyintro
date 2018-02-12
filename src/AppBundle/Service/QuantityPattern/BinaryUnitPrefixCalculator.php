<?php
namespace AppBundle\Service\QuantityPattern;

use AppBundle\Type\QuantityPattern\Unit\UnitPrefix;

final class DataUnitPrefixCalculator {
  private $unit;
  
  public function __construct() {
    $this->unit = [
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
  public function __invoke(float $value) {
    $unitLength = count($this->unit);
    $unitIndex = 0;

    while ($unitIndex < $unitLength
      && !parent::isReduced($value, $this->unit[$unitIndex])) {
      ++$unitIndex;
    }

    return $this->unit[$unitIndex];
  }
}