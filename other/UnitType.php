<?php
namespace AppBundle\Database\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Service\QuantityPattern\UnitFactory;

final class UnitType extends Type {
  const NAME = "unit";

  private $factory;

  public function __construct(UnitFactory $factory) {
    $this->factory = $factory;
  }

  public function getName() {
    return self::NAME;
  }

  public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
    return sprintf('VARCHAR(10)');
  }

  public function convertToPhpValue($value, AbstractPlatform $platform) {
    return $this->factory($value);
  }

  public function convertToDatabaseValue($value, AbstractPlatform $platform) {
    return $this->factory->find($value);
  }
}
