<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\QuantityPattern\Unit\Dimension;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityUnitDimensions_dimension_exponent", columns={ "dimension", "exponent" })
 *   })
 * @UniqueEntity(fields={ "dimension", "exponent" })
 */
final class UnitDimension {
  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Dimension", cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  private $dimension;

  /**
   * @ORM\Column(type="integer")
   */
  private $exponent;

  public function __construct(Dimension $dimension, $exponent) {
    $this->dimension = $dimension;
    $this->exponent = $exponent;
  }

  public function __toString() {
    return "$this->getDimension()^$this->getExponent()";
  }

  public function getDimension() {
    return $this->dimension;
  }

  public function getExponent() {
    return $this->exponent;
  }
}
