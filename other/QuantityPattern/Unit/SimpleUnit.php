<?php
namespace AppBundle\Type\QuantityPattern\Unit;

final class SimpleUnit extends BaseUnit {
  public function __construct(string $internal, string $name, string $symbol) {
    parent::__construct($internal, $name, $symbol);
  }
}
