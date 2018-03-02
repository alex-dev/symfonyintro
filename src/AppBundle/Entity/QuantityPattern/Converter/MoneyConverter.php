<?php
namespace AppBundle\Entity\QuantityPattern\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Converter\ZeroBasedLinearConverter;

/**
 * @ORM\Entity
 */
class MoneyConverter extends ZeroBasedLinearConverter {
  public function __construct($factor) {
    parent::__construct($factor);
  }

  public function updateFactor($value) {
    $this->factor = $value;
  }
}
