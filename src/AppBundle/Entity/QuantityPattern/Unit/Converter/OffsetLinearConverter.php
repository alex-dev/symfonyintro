<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 */
class OffsetLinearConverter extends Converter {
  /**
   * @Column(name="factor", type="float")
   */
  protected $factor;

  /**
   * @Column(name="offset", type="float")
   */
  protected $offset;


  public function __invoke(Converter $other) {
    return function (float $value) {
      return $other->convertFromBase($this->convertToBase($value));
    };
  }

  public function convertToBase(float $value) {
    return $value * $this->factor + $this->offset;
  }

  public function convertFromBase(float $value) {
    return ($value - $this->offset) * $this->factor;
  }
}
