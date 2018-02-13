<?php
namespace \AppBundle\Entity\QuantityPattern\Unit\Converter;

use \Doctrine\ORM\Mapping as ORM;
use \AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 */
class ZeroBasedLinearConverter extends Converter {
  /**
   * @ORM\Column(name="factor", type="float")
   */
  protected $factor;

  public function __invoke(Converter $other) {
    if ($other instanceof self) {
      return function (float $value) {
        return $value * $this->factor / $other->factor;
      };
    } else {
      return function (float $value) {
        return $other->convertFromBase($this->convertToBase($value));
      };
    }
  }

  protected function convertToBase(float $value) {
    return $value * $this->factor;
  }

  protected function convertFromBase(float $value) {
    return $value / $this->factor;
  }
}
