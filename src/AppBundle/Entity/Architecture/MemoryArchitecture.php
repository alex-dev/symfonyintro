<?php
namespace \AppBundle\Entity\Architecture;

use \Doctrine\ORM\Mapping as ORM;
use \AppBundle\Entity\Architecture\Architecture;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemoryArchitectures")
 */
class MemoryArchitecture extends Architecture {
  public function __construct() {
    parent::__construct();
  }
}
