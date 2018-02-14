<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Entity\Manufacturer;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\Entity
 * @ORM\Table(name="Memories")
 */
class Memory extends Product {
  private $size_dimensions;
  private $frequancy_dimensions;

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(name="size", referencedColumnName="idScalar")
   */
  protected $size;

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(name="frequency", referencedColumnName="idScalar")
   */
  protected $frequency;

  public function __construct(array $names, Manufacturer $manufacturer, Scalar $size, Scalar $frequency, DimensionsFactory $factory) {
    $this->size_dimensions = $factory('byte');
    $this->frequency_dimensions = $factory('hertz');

    parent::__construct($names, $manufacturer);
    $this->setSize($size);
  }

  /**
   * @return Scalar
   */
  public function getSize() {
    return $this->size;
  }

  /**
   * @return Scalar
   */
  public function getFrequency() {
    return $this->frequency;
  }

  /**
   * @return void
   * @throws UnitException if dimensions are not compatibles.
   */
  public function setSize(Scalar $value) {
    if ($value->getUnit()->getDimensions() != $this->size_dimensions) {
      throw new UnitException("$value->getUnit()->getDimensions() is not $this->size_dimensions.");
    } else {
      $this->size = $value;
    }
  }

  /**
   * @return void
   * @throws UnitException if dimensions are not compatibles.
   */
  public function setFrequency(Scalar $value) {
    if ($value->getUnit()->getDimensions() != $this->frequency_dimensions) {
      throw new UnitException("$value->getUnit()->getDimensions() is not $this->frequency_dimensions.");
    } else {
      $this->frequency = $value;
    }
  }
}
