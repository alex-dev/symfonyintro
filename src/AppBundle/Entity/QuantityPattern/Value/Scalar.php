<?php
namespace AppBundle\Entity\QuantityPattern\Value;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\GlobalConstants;
use AppBundle\Entity\QuantityPattern\Unit\Unit;
use AppBundle\Entity\QuantityPattern\Value\Value;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Scalar extends Value {
  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(type="float")
   */
  protected $value;

  public function getValue() {
    return $this->value;
  }

  public function __construct(Unit $unit, $value) {
    parent::__construct($unit);
    $this->value = $value;
  }

  public function __toString() {
    $value = round($this->value, $precision = GlobalConstants::FLOAT_DEFAULT_PRECISION);
    $unit = $this->getUnit();
    return "$value $unit";
  }

  public function isGreaterThan(Scalar $other) {
    return $this->getValue() > $other->convert($this->getUnit())->getValue();
  }

  public function isLesserThan(Scalar $other) {
    return $this->getValue() < $other->convert($this->getUnit())->getValue();
  }

  protected function convert_(Unit $to , callable $converter) {
    return new Scalar($to, $converter($this->getValue()));
  }
}
