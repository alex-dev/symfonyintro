<?php
namespace AppBundle\Type\QuantityPattern;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Type\QuantityPattern\Unit\Unit;
use Type\QuantityPattern\Unit\Prefix;

/**
 * @Entity
 * @Table(
 *   name="Scalars",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_Scalars_value_unit", columns={ "value", "unit" }),
 *   })
 * @UniqueEntity(fields={ "value", "unit" })
 */
final class Scalar extends Value {
  /**
   * @Id
   * @Column(name="idManufacturer", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  private $id;

  /**
   * @Column(name="value", type="float")
   * @Assert\NotNull()
   */
  private $value;

  public function __construct(Unit $unit, float $value) {
    parent::__construct($unit);
    $this->value = $value;
    $this->prefix = $this->getUnit()->getPrefix($this->getValue());
  }

  /**
   * @return float
   */
  public function getValue() {
    return $this->value / $this->getPrefix()->getFactor();
  }

  /**
   * @return Prefix
   */
  public function getPrefix() {
    return $this->prefix;
  }

  /**
   * @return Value
   */
  protected function convert_(Unit $to) {
    return new Scalar($to, $this->getUnit()->convert($to, $this->getValue()));
  }
}
