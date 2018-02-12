<?php
namespace AppBundle\Type\QuantityPattern;

use Unit\Unit;
use Unit\Prefix;

final class Scalar {
  private $value;
  private $prefix;

  public function __construct(Unit $unit, float $value) {
    parent::__construct($unit);
    $this->value = $value;
    $this->prefix = $this->getUnit()->getPrefix($this->getValue());
  }

  /**
   * @return float
   */
  public function getValue() {
    return $this->value / $this->getPrefix()->getFactor();
  }

  /**
   * @return Prefix
   */
  public function getPrefix() {
    return $this->prefix;
  }

  /**
   * @return Value
   */
  protected function convert_(Unit $to) {
    return new Scalar($to, $this->getUnit()->convert($to, $this->getValue()));
  }
}
