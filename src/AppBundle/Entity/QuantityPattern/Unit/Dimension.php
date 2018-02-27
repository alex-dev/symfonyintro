<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Repository\DimensionRepository;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_name", columns={ "name" }),
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_symbol", columns={ "symbol" })
 *   })
 * @UniqueEntity("name")
 * @UniqueEntity("symbol")
 */
class Dimension {
  const name_length = 50;
  const symbol_length = 5;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=Dimension::name_length)
   */
  private $name;

  private function getName() {
    return $this->name;
  }

  private function setName($value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length.' characters long.');
    } else {
      $this->name = $value;
    }
  }

  /**
   * @ORM\Column(type="string_sensitive", length=Dimension::symbol_length)
   */
  private $symbol;

  private function getSymbol() {
    return $this->symbol;
  }

  private function setSymbol($value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length.' characters long.');
    } else {
      $this->name = $value;
    }
  }

  public function __construct($name, $symbol) {
    $this->setName($name);
    $this->setSymbol($symbol);
  }

  public function __toString() {
    return $this->getSymbol();
  }
}
