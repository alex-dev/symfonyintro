<?php
namespace AppBundle\Entity\QuantityPattern\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Converter\Converter;

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

  public function __construct($factor, $offset) {
    $this->factor = $factor;
    $this->offset = $offset;
  }

  public function __invoke(Converter $other = null) {
    if (is_null($other)) {
      return function ($value) {
        return $other->convertFromBase($value);
      };
    } else {
      return function ($value) use (&$other) {
        return $other->convertFromBase($this->convertToBase($value));
      };
    }
  }

  public function isMain() {
    return $this->factor == 1 && $this->offset == 0;
  }

  protected function convertToBase($value) {
    return $value * $this->factor + $this->offset;
  }

  protected function convertFromBase($value) {
    return ($value - $this->offset) * $this->factor;
  }
}
