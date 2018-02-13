<?php
namespace AppBundle\Service;

use Type\QuantityPattern\UnitPrefix\BinaryPrefix;

final class BinaryPrefixFactory {
  public function __construct() {
    $this->mapping = [
      '' => new BinaryPrefix('', '', 0),
      'kibi' => new BinaryPrefix('unit.prefix.kibi', 'symbol.prefix.kibi', 1024),
      'mibi' => new BinaryPrefix('unit.prefix.mibi', 'symbol.prefix.mibi', 1024 ** 2),
      'gibi' => new BinaryPrefix('unit.prefix.gibi', 'symbol.prefix.gibi', 1024 ** 3),
      'tebi' => new BinaryPrefix('unit.prefix.tebi', 'symbol.prefix.tebi', 1024 ** 4),
      'pebi' => new BinaryPrefix('unit.prefix.pebi', 'symbol.prefix.pebi', 1024 ** 5),
      'exbi' => new BinaryPrefix('unit.prefix.exbi', 'symbol.prefix.exbi', 1024 ** 6),
      'zebi' => new BinaryPrefix('unit.prefix.zebi', 'symbol.prefix.zebi', 1024 ** 7),
      'yobi' => new BinaryPrefix('unit.prefix.yobi', 'symbol.prefix.yobi', 1024 ** 8)
    ];
  }
}
