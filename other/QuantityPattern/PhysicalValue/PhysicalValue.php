<?php
namespace AppBundle\Type\QuantityPattern\PhysicalValue;

use Unit\BaseUnit;

abstract class PhysicalValue {
  private $value;
  private $unit;

  public function __construct(float $value, BaseUnit $unit) {
    
  }
}