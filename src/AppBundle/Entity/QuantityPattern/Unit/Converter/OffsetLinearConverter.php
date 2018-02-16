<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 */
class OffsetLinearConverter extends Converter {
  /**
   * @ORM\Column(type="float")
   */
  protected $factor;

  /**
   * @ORM\Column(type="float")
   */
  protected $offset;


  public function __invoke(Converter $other) {
    return function ($value) {
      return $other->convertFromBase($this->convertToBase($value));
    };
  }

  protected function convertToBase($value) {
    return $value * $this->factor + $this->offset;
  }

  protected function convertFromBase($value) {
    return ($value - $this->offset) * $this->factor;
  }
}
