<?php
namespace AppBundle\Entity\QuantityPattern;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\CustomException\UnitException;
use AppBundle\Entity\QuantityPattern\Unit\Unit;

/**
 * @ORM\MappedSuperclass
 */
abstract class Value {
  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Unit\Unit",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(name="idUnit", referencedColumnName="idUnit")
   */
  protected $unit;
  
  public function __construct(Unit $unit) {
    $this->unit = $unit;
  }

  abstract public function __toString();

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
   * @return Value
   */
  abstract protected function convert_(Unit $to);
}
