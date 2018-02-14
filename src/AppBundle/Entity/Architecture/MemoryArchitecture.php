<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ECC;
use AppBundle\Entity\Architecture\Architecture;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemoryArchitectures")
 */
class MemoryArchitecture extends Architecture {
  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\ECC",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(name="idECC", referencedColumnName="idECC", nullable=false)
   */
  protected $ECC;

  public function __construct(array $names, array $abbreviations) {
    parent::__construct($names, $abbreviations);
  }

  public function getECC() {
    return $this->ECC;
  }

  public function setECC(ECC $value) {
    $this->ECC = $value;
  }
}
