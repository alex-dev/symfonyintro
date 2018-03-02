<?php
namespace AppBundle\Entity\QuantityPattern\Value;

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
   * @ORM\JoinColumn(nullable=false)
   */
  protected $unit;

  public function getUnit() {
    return $this->unit;
  }
  
  public function __construct(Unit $unit) {
    $this->unit = $unit;
  }

  abstract public function __toString();
  
  /**
   * @return double
   */
  public function convertToBase() {
    return $this->convert_($to, $this->getUnit()->getBaseConversion());
  }

  /**
   * @return Value
   * @throws UnitException if $this is not convertible to $to 
   */
  public function convert(Unit $to) {
    if (!$this->unit->isConvertibleTo($to)) {
      throw new UnitException("$this->getUnit() is not convertible to $to.");
    } else {
      return $this->convert_($to, $this->getUnit()->getConversion($to));
    }
  }

  /**
   * @return Value
   */
  abstract protected function convert_(Unit $to, callable $converter);
}
