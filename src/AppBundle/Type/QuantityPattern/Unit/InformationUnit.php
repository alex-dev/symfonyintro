<?php
namespace AppBundle\Type\QuantityPattern\Unit;

use Service\DimensionFactory;

abstract class InformationUnit extends Unit {
  public function __construct(DimensionFactory $factory) {
    parent::__construct([
      new Pair($factory->create('Information'), 1)
    ]);
  }
}
