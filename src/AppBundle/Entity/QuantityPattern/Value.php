<?php
namespace AppBundle\Type\QuantityPattern;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Symfony\Component\Validator\Constraints as Assert;
use Exception\UnitException;
use Type\QuantityPattern\Unit\Unit;
use Type\QuantityPattern\Unit\Prefix;

/**
 * @MappedSuperclass
 */
abstract class Value {
  /**
   * @Column(name="unit", type="unit")
   * @Assert\NotNull()
   */
  protected $unit;
  
  public function __construct(Unit $unit) {
    $this->unit = $unit;
  }

  /**
   * @return Unit
   */
  public function getUnit() {
    return $this->unit;
  }

  /**
   * @return Value
   * @throws UnitException if $this is not convertible to $to 
   */
  public function convert(Unit $to) {
    if (!$this->unit->isConvertible($unit)) {
      throw new UnitException("$this->getUnit() is not convertible to $unit.");
    } else {
      return $this->convert_($to);
    }
  }

  /**
   * @return Prefix
   */
  abstract public function getPrefix();

  /**
   * @return Value
   */
  abstract protected function convert_(Unit $to);
}
