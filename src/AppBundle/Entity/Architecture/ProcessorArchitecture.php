<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Architecture\Architecture;

/**
 * @ORM\Entity
 */
class ProcessorArchitecture extends Architecture {
  public function __construct(array $names, array $abbreviations) {
    parent::__construct($names, $abbreviations);
  }
}
