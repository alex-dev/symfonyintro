<?php
namespace AppBundle\Type\QuantityPattern\UnitPrefix;

final class DecimalPrefix extends UnitPrefix {
  public function __construct(string $prefix, string $symbol, float $factor) {
    parent::__construct($prefix, $symbol, $factor);
  }
}
