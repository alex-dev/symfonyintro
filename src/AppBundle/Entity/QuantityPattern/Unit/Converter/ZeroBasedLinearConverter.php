<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 */
class ZeroBasedLinearConverter extends Converter {
  /**
   * @ORM\Column(type="float")
   */
  protected $factor;

  public function __construct($factor) {
    $this->factor = $factor;
  }

  public function __invoke(Converter $other) {
    if ($other instanceof self) {
      return function ($value) use (&$other) {
        return $value * $this->factor / $other->factor;
      };
    } else {
      return function ($value) use (&$other) {
        return $other->convertFromBase($this->convertToBase($value));
      };
    }
  }

  public function isMain() {
    return $this->factor == 1;
  }

  protected function convertToBase($value) {
    return $value * $this->factor;
  }

  protected function convertFromBase($value) {
    return $value / $this->factor;
  }
}
