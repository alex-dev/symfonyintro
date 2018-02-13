<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Service\QuantityPattern\DimensionFactory;
use Service\QuantityPattern\AbstractUnitPrefixCalculator;

abstract class InformationUnit extends Unit {
  public function __construct(DimensionFactory $factory, AbstractUnitPrefixcalculator $prefix) {
    parent::__construct([
      new Pair($factory('Information'), 1),
      $prefix
    ]);
  }
}
