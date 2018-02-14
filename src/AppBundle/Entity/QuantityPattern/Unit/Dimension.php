<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Repository\DimensionRepository;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="QuantityDimensions",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_name", columns={ "name" }),
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_symbol", columns={ "symbol" })
 *   })
 * @UniqueEntity("name")
 * @UniqueEntity("symbol")
 */
final class Dimension {
  const name_length = 50;
  const symbol_length = 5;

  /**
   * @ORM\Id
   * @ORM\Column(name="idDimension", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\Column(name="name", type="string", length=Dimension::name_length)
   */
  private $name;

  /**
   * @ORM\Column(name="symbol", type="string", length=Dimension::symbol_length)
   */
  private $symbol;

  public function __construct(string $name, string $symbol) {
    $this->setName($name);
    $this->setSymbol($symbol);
  }

  public function __toString() {
    return $this->symbol;
  }

  private function setName(string $value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }

  private function setSymbol(string $value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }
}
