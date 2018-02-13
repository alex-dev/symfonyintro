<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @DiscriminatorMap({
 *   "zerobased" = "ZeroBasedConverter",
 *   "offsetlinear" = "OffsetLinearConverter"
 * })
 * @Table(name="Converters")
 */
abstract class Converter {
  /**
   * @Id
   * @Column(name="idProduct", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  protected $id;

  abstract public function __invoke(IConverter $other);
  abstract public function convertToBase(float $value);
  abstract public function convertFromBase(float $value);
}
