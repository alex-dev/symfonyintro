<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Repository\MemoryRepository;
use AppBundle\Entity\Architecture\MemoryArchitecture;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemoryRepository")
 * @ORM\Table
 */
class Memory extends Product {
  private $size_dimensions;
  private $frequancy_dimensions;

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $size;

  public function getSize() {
    return $this->size;
  }

  public function setSize(Scalar $value) {
    if ($value->getUnit()->getDimensions() != $this->size_dimensions) {
      throw new UnitException("$value->getUnit()->getDimensions() is not $this->size_dimensions.");
    } else {
      $this->size = $value;
    }
  }

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $frequency;

  public function getFrequency() {
    return $this->frequency;
  }

  public function setFrequency(Scalar $value) {
    if ($value->getUnit()->getDimensions() != $this->frequency_dimensions) {
      throw new UnitException("$value->getUnit()->getDimensions() is not $this->frequency_dimensions.");
    } else {
      $this->frequency = $value;
    }
  }

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Architecture\MemoryArchitecture",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $architecture;

  public function getArchitecture() {
    return $this->architecture;
  }

  public function setArchitecture(MemoryArchitecture $architecture) {
    $this->architecture = $architecture;
  }

  public function __construct($code, array $names, array $images, Manufacturer $manufacturer, MemoryArchitecture $architecture, Scalar $size, Scalar $frequency, DimensionsFactory $factory) {
    $this->size_dimensions = $factory('byte');
    $this->frequency_dimensions = $factory('hertz');

    parent::__construct($code, $names, $images, $manufacturer);
    $this->setArchitecture($architecture);
    $this->setSize($size);
    $this->setFrequency($frequency);
  }
}
