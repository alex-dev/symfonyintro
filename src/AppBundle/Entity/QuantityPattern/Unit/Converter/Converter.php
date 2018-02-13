<?php
namespace \AppBundle\Entity\QuantityPattern\Unit\Converter;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *   "zerobased" = "ZeroBasedConverter",
 *   "offsetlinear" = "OffsetLinearConverter"
 * })
 * @ORM\Table(name="Converters")
 */
abstract class Converter {
  /**
   * @ORM\Id
   * @ORM\Column(name="idProduct", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  abstract public function __invoke(IConverter $other);
  abstract protected function convertToBase(float $value);
  abstract protected function convertFromBase(float $value);
}
