<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @Entity
 */
class ZeroBasedLinearConverter extends Converter {
  /**
   * @Column(name="factor", type="float")
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

  public function convertToBase(float $value) {
    return $value * $this->factor;
  }

  public function convertFromBase(float $value) {
    return $value / $this->factor;
  }
}
