<?php
namespace \AppBundle\Type\QuantityPattern;

use \Doctrine\ORM\Mapping as ORM;
use \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \AppBundle\Type\QuantityPattern\Value;
use \AppBundle\Type\QuantityPattern\Unit\Unit;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="Scalars",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Scalars_value_unit", columns={ "value", "unit" }),
 *   })
 * @ORM\UniqueEntity(fields={ "value", "unit" })
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

  /**
   * @return float
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @return Value
   */
  protected function convert_(Unit $to) {
    $converter = $this->getUnit()->getConverter($to);
    return new Scalar($to, $converter($value));
  }
}
