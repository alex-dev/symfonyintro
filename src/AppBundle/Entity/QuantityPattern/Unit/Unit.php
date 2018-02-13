<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Exception\UnitException;
use Converter\Converter;

/**
 * @Entity
 * @Table(
 *   name="Units",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_QuantityDimensions_name", columns={ "name" })
 *     @UniqueConstraint(name="UK_QuantityDimensions_symbol", columns={ "symbol" })
 *   })
 * @UniqueEntity("name")
 * @UniqueEntity("symbol")
 */
final class Unit {
  const name_length = 50;
  const symbol_length = 5;

  /**
   * @Id
   * @Column(name="idUnit", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  private $id;

  /**
   * @Column(name="name", type="string", length=Dimension::name_length)
   */
  private $name;

  /**
   * @Column(name="symbol", type="string", length=Dimension::symbol_length)
   */
  private $symbol;

  /**
   * @ManyToMany(targetEntity="UnitDimension", cascade={ "persist", "refresh" })
   * @JoinTable(
   *   name="Units_UnitDimensions",
   *   joinColumns={ @JoinColumn(name="idUnit", referencedColumnName="idUnit") },
   *   inverseJoinColumns={ @JoinColumn(name="idUnitDimension", referencedColumnName="idUnitDimension") },
   */
  private $dimensions;

  /**
   * @OneToOne(targetEntity="Converter", cascade={ "persist", "refresh" })
   * @JoinColumn(name="idConverter", referencedColumnName="idConverter")
   */
  private $converter;

  public function __construct(string $name, string $symbol, array $dimensions, callable $converter) {
    $this->setName($name);
    $this->setSymbol($symbol);
    $this->setDimensions($dimensions);
    $this->setConverter($converter);
  }

  public function __toString() {
    return $this->symbol;
  }

  public function getName() {
    return $this->name;
  }

  public function getDimensions() {
    // TODO: to string
    return $this->dimensions;
  }

  public function isConvertibleTo(Unit $to) {
    return $this->getDimensions_() === $to->getDimensions_();
  }

  public function getConverter(Unit $to) {
    if (!$this->isConvertibleTo($to)) {
      throw new UnitException("$this is not convertible to $to.");
    } else {
      $converter = $this->getConverter();
      return $converter($to->getConverter_());
    }
  }

  private function getDimensions_() {
    return $this->dimensions;
  }

  private function getConverter_() {
    return $this->converter;
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

  private function setDimensions(array $value) {
    if (array_count(array_flip(array_map(function (Dimension $dimension) {
      return $dimension->getDimension();
    }, $value))) !== array_count($value)) {
      throw new UnitException("$value is not sufficiently reduced.");
    } else {
      $this->dimensions = new ArrayCollection($value);
    }
  }

  private function setConverter(callable $value) {
    $this->converter = $converter;
  }
}
