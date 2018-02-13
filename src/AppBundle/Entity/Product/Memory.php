<?php
namespace \AppBundle\Entity\Product;

use \Doctrine\ORM\Mapping as ORM;
use \AppBundle\Entity\Manufacturer;
use \AppBundle\Entity\QuantityPattern\Scalar;
use \AppBundle\Entity\Product\Product;

/**
 * @Entity
 * @Table(name="Memories")
 */
class Memory extends Product {
  /**
   * @ORM\OneToOne(targetEntity="Scalar", orphanRemoval=true, cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(name="size", referencedColumnName="idScalar")
   */
  protected $size;

  /**
   * @ORM\OneToOne(targetEntity="Scalar", orphanRemoval=true, cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(name="frequency", referencedColumnName="idScalar")
   */
  protected $frequency;

  public function __construct(array $names, Manufacturer $manufacturer, Scalar $size, Scalar $frequency) {
    parent::__construct($names, $manufacturer);
    $this->setSize($size);
  }

  /**
   * @return Scalar
   */
  public function getSize() {
    return $this->size;
  }

  public function setSize(Scalar $value) {
    if ()
  }
}
