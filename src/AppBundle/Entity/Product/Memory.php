<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Exception\UnitException;
use AppBundle\Entity\Architecture\MemoryArchitecture;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Value\Scalar;
use AppBundle\Service\Factory\DimensionsFactory;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Memory extends Product {
  const frequencyUnit = 'hertz';
  const sizeUnit = 'byte';

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Value\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $size;

  public function getSize() {
    return $this->size;
  }

  public function setSize(Scalar $value) {
    $this->setSize_($value, $this->getSize()->getDimensions());
  }

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Value\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $frequency;

  public function getFrequency() {
    return $this->frequency;
  }

  public function setFrequency(Scalar $value) {
    $this->setFrequency_($value, $this->getFrequency()->getDimensions());
  }

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Architecture\MemoryArchitecture",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   * @Assert\NotNull(message="product.architecture.null")
   */
  protected $architecture;

  public function getArchitecture() {
    return $this->architecture;
  }

  public function setArchitecture(MemoryArchitecture $architecture) {
    $this->architecture = $architecture;
  }
  
  public function __construct(
    $code,
    array $names,
    array $images,
    Manufacturer $manufacturer = null,
    MemoryArchitecture $architecture,
    Scalar $size,
    Scalar $frequency,
    DimensionsFactory $factory) {
    parent::__construct($code, $names, $images, $manufacturer);
    $this->setArchitecture($architecture);
    $this->setSize_($size, $factory(self::sizeUnit));
    $this->setFrequency_($frequency, $factory(self::frequencyUnit));
  }

  protected function setSize_(Scalar $value, $dimensions) {
    if ($value->getUnit()->getTrueDimensions() != $dimensions) {
      throw new UnitException($value->getUnit()->getDimensions()." is not $dimensions.");
    } else {
      $this->size = $value;
    }
  }

  protected function setFrequency_(Scalar $value, $dimensions) {
    if ($value->getUnit()->getTrueDimensions() != $dimensions) {
      throw new UnitException($value->getUnit()->getDimensions()." is not $dimensions.");
    } else {
      $this->frequency = $value;
    }
  }
}
