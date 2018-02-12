<?php
namespace AppBundle\Service\QuantityPattern\QuantityConverter;

use Exception\UnitException;
use Type\QuantityPattern\Unit\BaseUnit;

abstract class QuantityConverter {
  public function convert(float $value, BaseUnit $from, BaseUnit $to) {
    if ($from != $this->getSimple() && !in_array($from, $this->getAllDerived())) {
      throw new UnitException("$from is not handled by $this.");
    } else if ($to != $this->getSimple() && !in_array($to, $this->getAllDerived())) {
      throw new UnitException("$to is not handled by $this.");
    } else {
      if ($from == $to) {
        return $value;
      } else if ($from == $this->getSimple()) {
        return $to->convertFromBaseUnit($value);
      } else if ($to == $this->getSimple()) {
        return $from->convertToBaseUnit($value);
      } else {
        return $to->convertFromBaseUnit($from->convertToBaseUnit($value));
      }
    }
  }

  public function parse(string $value) {
    if ($value === $this->getSimple()->getInternalName()) {
      return $this->simple;
    } else {
      foreach ($this->getAllDerived() as $unit) {
        if ($value === $unit->getInternalName()) {
          return $unit;
        }
      }

      throw new UnitException("$value is not handled by $this.");
    }
  }

  protected abstract function getSimple();

  protected abstract function getAllDerived();
}
