<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Entity
 * @Table(
 *   name="QuantityUnitDimensions",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_QuantityUnitDimensions_idDimension_exponant", columns={ "idDimension", "exponant" })
 *   })
 * @UniqueEntity(fields={ "dimension", "exponent" })
 */
final class UnitDimension {
  const name_length = 50;
  const symbol_length = 5;

  /**
   * @Id
   * @Column(name="idUnitDimension", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  private $id;

  /**
   * @ManyToOne(targetEntity="Dimension", cascade={ "persist", "refresh" })
   * @JoinColumn(name="idDimension", referencedColumnName="idDimension")
   */
  private $dimension;

  /**
   * @Column(name="exponent", type="integer")
   */
  private $exponant;

  public function __construct(Dimension $dimension, integer $exponent) {
    $this->dimension = $dimension;
    $this->exponent = $exponent;
  }

  public function __toString() {
    return "$this->exponent^$exponent";
  }

  public function getDimension() {
    return $this->dimension;
  }

  public function getExponant() {
    return $this->exponant;
  }
}
