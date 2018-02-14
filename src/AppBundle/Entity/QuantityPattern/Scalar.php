<?php
namespace AppBundle\Entity\QuantityPattern;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\GlobalConstants;
use AppBundle\Entity\QuantityPattern\Value;
use AppBundle\Entity\QuantityPattern\Unit\Unit;

/**
 * @ORM\Entity
 * @ORM\Table(name="Scalars")
 */
final class Scalar extends Value {
  /**
   * @ORM\Id
   * @ORM\Column(name="idScalar", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\Column(name="value", type="float")
   */
  private $value;

  public function __construct(Unit $unit, float $value) {
    parent::__construct($unit);
    $this->value = $value;
  }

  public function __toString() {
    $value = round($this->value, $precision=GlobalConstants::FLOAT_DEFAULT_PRECISION);
    return $value.$this->unit;
  }

  /**
   * @return float
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @return Scalar
   */
  protected function convert_(Unit $to) {
    $converter = $this->getUnit()->getConverter($to);
    return new Scalar($to, $converter($value));
  }
}
