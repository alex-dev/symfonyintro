<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 */
class OffsetLinearConverter extends Converter {
  /**
   * @ORM\Column(name="factor", type="float")
   */
  protected $factor;

  /**
   * @ORM\Column(name="offset", type="float")
   */
  protected $offset;


  public function __invoke(Converter $other) {
    return function (float $value) {
      return $other->convertFromBase($this->convertToBase($value));
    };
  }

  protected function convertToBase(float $value) {
    return $value * $this->factor + $this->offset;
  }

  protected function convertFromBase(float $value) {
    return ($value - $this->offset) * $this->factor;
  }
}
