<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="GraphicAcceleratorArchitectures")
 */
class GraphicAcceleratorArchitecture extends Architecture {
  public function __construct() {
    parent::__construct();
  }
}
