<?php
namespace AppBundle\Type\QuantityPattern\Unit;

abstract class BaseUnit {
  private $internal;
  private $name;
  private $symbol;

  public function __construct(string $internal, string $name, string $symbol) {
    $this->internal = $internal;
    $this->name = $name;
    $this->symbol = $symbol;
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->internal;
  }

  /**
   * @return string
   */
  public function getInternalName() {
    return $this->internal;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getSymbol() {
    return $this->symbol;
  }
}
