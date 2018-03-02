<?php
namespace AppBundle\Entity\QuantityPattern\Converter;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=50)
 * @ORM\Table
 */
abstract class Converter {
  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  abstract public function __invoke(Converter $other = null);
  abstract public function isMain();
  abstract protected function convertToBase($value);
  abstract protected function convertFromBase($value);
}
