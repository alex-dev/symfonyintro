<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\QuantityPattern\Unit\Dimension;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="QuantityUnitDimensions",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityUnitDimensions_idDimension_Exponent", columns={ "idDimension", "exponent" })
 *   })
 * @UniqueEntity(fields={ "dimension", "exponent" })
 */
final class UnitDimension {
  /**
   * @ORM\Id
   * @ORM\Column(name="idUnitDimension", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Dimension", cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(name="idDimension", referencedColumnName="idDimension")
   */
  private $dimension;

  /**
   * @ORM\Column(name="exponent", type="integer")
   */
  private $Exponent;

  public function __construct(Dimension $dimension, integer $exponent) {
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
