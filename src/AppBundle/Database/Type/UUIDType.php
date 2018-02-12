<?php
namespace AppBundle\Database\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Type\UUID;

final class UUIDType extends Type {
  const NAME = "uuid_binary";

  public function getName() {
    return self::NAME;
  }

  public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
    return sprintf('BINARY(%d)', $fieldDeclaration['length']);
  }

  public function convertToPhpValue($value, AbstractPlatform $platform) {
    return $value === null ? null : UUID::createFromHex($uuid);
  }

  public function convertToDatabaseValue($value, AbstractPlatform $platform) {
    return $value === null ? null : $value->toHex();
  }
}
