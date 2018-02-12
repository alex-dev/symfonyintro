<?php
namespace AppBundle\Service;

use Type\QuantityPattern\UnitPrefix\DecimalPrefix;

final class BinaryPrefixFactory {
  public function __construct() {
    $this->mapping = [
      '' => new DecimalPrefix('', '', 0),
      'exa' => new DecimalPrefix('unit.prefix.exa', 'symbol.prefix.exa', 10 ** 18),
      'peta' => new DecimalPrefix('unit.prefix.peta', 'symbol.prefix.peta', 10 ** 15),
      'tera' => new DecimalPrefix('unit.prefix.tera', 'symbol.prefix.tera', 10 ** 12),
      'giga' => new DecimalPrefix('unit.prefix.giga', 'symbol.prefix.giga', 10 ** 9),
      'mega' => new DecimalPrefix('unit.prefix.mega', 'symbol.prefix.mega', 10 ** 6),
      'kilo' => new DecimalPrefix('unit.prefix.kilo', 'symbol.prefix.kilo', 10 ** 3),
      'milli' => new DecimalPrefix('unit.prefix.milli', 'symbol.prefix.milli', 10 ** -3),
      'micro' => new DecimalPrefix('unit.prefix.micro', 'symbol.prefix.micro', 10 ** -6),
      'nano' => new DecimalPrefix('unit.prefix.nano', 'symbol.prefix.nano', 10 ** -9),
      'pico' => new DecimalPrefix('unit.prefix.pico', 'symbol.prefix.pico', 10 ** -12),
      'femto' => new DecimalPrefix('unit.prefix.femto', 'symbol.prefix.femto', 10 ** -15),
      'atto' => new DecimalPrefix('unit.prefix.atto', 'symbol.prefix.atto', 10 ** -18),
    ];
  }
}