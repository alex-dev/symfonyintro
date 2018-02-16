<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *   "zerobased" = "ZeroBasedLinearConverter",
 *   "offsetlinear" = "OffsetLinearConverter"
 * })
 * @ORM\Table
 */
abstract class Converter {
  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  abstract public function __invoke(Converter $other);
  abstract protected function convertToBase($value);
  abstract protected function convertFromBase($value);
}
