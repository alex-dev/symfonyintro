<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\CustomException\UnitException;
use AppBundle\Entity\QuantityPattern\Unit\UnitDimension;
use AppBundle\Entity\QuantityPattern\Unit\UnitTranslation;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity(repositoryClass="UnitRepository")
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityUnit_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
final class Unit {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=20)
   */
  private $key;

  /**
   * @ORM\ManyToMany(targetEntity="UnitDimension", cascade={ "persist", "refresh" })
   * @ORM\JoinTable(
   *   joinColumns={ @ORM\JoinColumn(name="unit", referencedColumnName="id", nullable=false) },
   *   inverseJoinColumns={ @ORM\JoinColumn(name="dimension", referencedColumnName="id", nullable=false) })
   */
  private $dimensions;

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Unit\Converter\Converter",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  private $converter;

  public function __construct(array $names, array $symbols, array $dimensions, callable $converter, $key) {
    $this->key = $key;
    
    $this->setDimensions($dimensions);
    $this->setConverter($converter);

    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }
    
    foreach ($symbols as $locale=>$symbol) {
      $this->translate($locale)->setSymbol($symbol);
    }
  }

  public function __call($method, $arguments) {
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
