<?php
namespace AppBundle\Type\QuantityPattern;

final class UnitPrefix {
  private $prefix;
  private $symbol;
  private $factor;

  public function __construct(string $prefix, string $symbol, float $factor) {
    $this->prefix = $prefix;
    $this->symbol = $symbol;
    $this->factor = $factor;
  }

  /**
   * @return string
   */
  public function getPrefix() {
    return $this->prefix;
  }

  /**
   * @return string
   */
  public function getSymbol() {
    return $this->symbol;
  }

  /**
   * @return int
   */
  public function getFactor() {
    return $this->factor;
  }
}