<?php
namespace AppBundle\Type\QuantityPattern;

use Exception\UnitException;
use Unit\Unit;
use Unit\Prefix;

abstract class Value {
  private $unit;
  
  public function __construct(Unit $unit) {
    $this->unit = $unit;
  }

  /**
   * @return Unit
   */
  public function getUnit() {
    return $this->unit;
  }

  /**
   * @return Value
   * @throws UnitException if $this is not convertible to $to 
   */
  public function convert(Unit $to) {
    if (!$this->unit->isConvertible($unit)) {
      throw new UnitException("$this->getUnit() is not convertible to $unit.");
    } else {
      return $this->convert_($to);
    }
  }

  /**
   * @return Prefix
   */
  abstract public function getPrefix();

  /**
   * @return Value
   */
  abstract protected function convert_(Unit $to);
}
