<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="ProcessorArchitectures")
 */
class ProcessorArchitecture extends Architecture {
  public function __construct() {
    parent::__construct();
  }
}
