<?php
namespace \AppBundle\Entity\QuantityPattern\Unit;

use \Doctrine\Common\Collections\ArrayCollection;
use \Doctrine\ORM\Mapping as ORM;
use \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \Symfony\Component\PropertyAccess\PropertyAccess;
use \Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use \AppBundle\Exception\UnitException;
use \AppBundle\Entity\QuantityPattern\Unit\UnitDimension;
use \AppBundle\Entity\QuantityPattern\Unit\UnitTranslation;
use \AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="QuantityUnits",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_name", columns={ "name" })
 *     @ORM\UniqueConstraint(name="UK_QuantityDimensions_symbol", columns={ "symbol" })
 *   })
 * @UniqueEntity("name")
 * @UniqueEntity("symbol")
 */
final class Unit {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(name="idUnit", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\ManyToMany(targetEntity="UnitDimension", cascade={ "persist", "refresh" })
   * @ORM\JoinTable(
   *   name="QuantityUnits_QuantityUnitDimensions",
   *   joinColumns={ @ORM\JoinColumn(name="idUnit", referencedColumnName="idUnit") },
   *   inverseJoinColumns={ @ORM\JoinColumn(name="idUnitDimension", referencedColumnName="idUnitDimension") },
   */
  private $dimensions;

  /**
   * @ORM\OneToOne(targetEntity="Converter", cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(name="idConverter", referencedColumnName="idConverter")
   */
  private $converter;

  public function __construct(array $names, array $symbols, array $dimensions, callable $converter) {
    $this->setDimensions($dimensions);
    $this->setConverter($converter);

    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }
    
    foreach ($symbols as $locale=>$symbol) {
      $this->translate($locale)->setSymbol($symbol);
    }
  }

  public function __call($method, $arguments)
  {
    if (count($arguments) > 0 || !in_array($method, ['getName', 'getSymbol', 'setName', 'setSymbol'])) {
      throw new BadMethodCallException("$method is not supported by $this.");
    } else {
      return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
  }

  public function __toString() {
    return $this->getSymbol();
  }

  public function getDimensions() {
    return array_reduce($this->getDimensions_(), function ($carry, $item) {
      return $carry.' '.$item;
    }, '');
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
