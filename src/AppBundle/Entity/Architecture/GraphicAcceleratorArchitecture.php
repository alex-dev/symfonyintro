<?php
namespace \AppBundle\Entity\Architecture;

use \Doctrine\ORM\Mapping as ORM;
use \AppBundle\Entity\Architecture\Architecture;

/**
 * @ORM\Entity
 * @ORM\Table(name="GraphicAcceleratorArchitectures")
 */
class GraphicAcceleratorArchitecture extends Architecture {
  public function __construct() {
    parent::__construct();
  }
}
