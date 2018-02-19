<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 */
class MoneyConverter extends Converter {
  public function __invoke(Converter $other) {
    return function ($value) use (&$other) {
      return $value;
    };
  }

  protected function convertToBase($value) {
    return $value;
  }

  protected function convertFromBase($value) {
    return $value;
  }
}
