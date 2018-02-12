<?php
namespace AppBundle\Service\QuantityPattern;

use AppBundle\Type\QuantityPattern\Unit\UnitPrefix;

abstract class DataUnitPrefixCalculator {
  /**
   * @return UnitPrefix
   */
  abstract public function __invoke(float $value);

  protected function isReduced(float $value, UnitPrefix $unit) {
    return $value / $unit.getFactor() < 1000;
  }

  protected function isIncreased(float $value, UnitPrefix $unit) {
    return $value / $unit.getFactor() > 0.0001;
  }
}
