<?php
namespace AppBundle\Service\QuantityPattern\Quantity;

use Unit\Unit;
use Unit\Prefix;

final class Scalar {
  private $value;

  public function __construct(Unit $unit, float $value) {
    parent::__construct($unit);
    $this->value = $value;
  }

  /**
   * @return float
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @return void
   */
  public function setValue(float $value) {
    $this->value = $value;
  }

  /**
   * @return Prefix
   */
  public function getPrefix() {
    // TODO: implements Prefix
  }

  /**
   * @return Value
   */
  protected function convert_(Unit $to) {
    return new Scalar($to, $this->getUnit()->convert($to, $this->getValue()));
  }
}
