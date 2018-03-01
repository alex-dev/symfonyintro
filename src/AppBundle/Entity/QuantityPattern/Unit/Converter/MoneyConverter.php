<?php
namespace AppBundle\Entity\QuantityPattern\Unit\Converter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Converter\ZeroBasedLinearConverter;

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
