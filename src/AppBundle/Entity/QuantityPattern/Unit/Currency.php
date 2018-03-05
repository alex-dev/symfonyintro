<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\QuantityPattern\Unit\Unit;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuantityPattern\UnitRepository")
 */
class Currency extends Unit {
  const unitBefore = '/^en.+$/';

  public function write($value, $locale) {
    if (preg_match(self::unitBefore, $locale)) {
      return $this->getSymbol($locale).' '.number_format($value, 2);
    } else {
      return number_format($value, 2).' '.$this->getSymbol($locale);
    }
  }
}
