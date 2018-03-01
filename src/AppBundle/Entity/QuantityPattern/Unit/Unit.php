<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\CustomException\UnitException;
use AppBundle\Repository\UnitRepository;
use AppBundle\Entity\QuantityPattern\Unit\UnitDimension;
use AppBundle\Entity\QuantityPattern\Unit\UnitTranslation;
use AppBundle\Entity\QuantityPattern\Unit\Converter\Converter;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitRepository")
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityUnit_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
class Unit {
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

  public function getKey() {
    return $this->key;
  }

  private function setKey($value) {
    $this->key = $value;
  }

  /**
   * @ORM\ManyToMany(
   *   targetEntity="UnitDimension",
   *   cascade={ "persist", "refresh" },
   *   fetch="EAGER")
   * @ORM\JoinTable(
   *   joinColumns={
   *     @ORM\JoinColumn(name="unit", nullable=false)
   *   },
   *   inverseJoinColumns={
   *     @ORM\JoinColumn(name="dimension", nullable=false)
   *   })
   */
  private $dimensions;

  public function getDimensions() {
    return array_reduce($this->dimensions, function ($carry, $item) {
      return $carry.' '.$item;
    }, '');
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

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Unit\Converter\Converter",
   *   cascade={ "persist", "refresh" },
   *   fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
  private $converter;
  
  public function getConverter() {
    return $this->converter;
  }

  private function setConverter(callable $value) {
    $this->converter = $converter;
  }

  public function getName() {
    return $this->translate()->getName();
  }

  public function getSymbol() {
    return $this->translate()->getSymbol();
  }

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

  public function __toString() {
    return $this->getSymbol();
  }

  public function isMain() {
    return $this->getConverter()->isMain();
  }

  public function isConvertibleTo(Unit $to) {
    return $this->dimensions == $to->dimensions;
  }

  public function getConversion(Unit $to) {
    if (!$this->isConvertibleTo($to)) {
      throw new UnitException("$this is not convertible to $to.");
    } else {
      $converter = $this->getConverter();
      return $converter($to->getConverter());
    }
  }
}
