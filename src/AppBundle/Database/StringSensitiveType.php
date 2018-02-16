<?php
namespace AppBundle\Database;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use AppBundle\Type\UUID;

final class StringSensitiveType extends Type {
  const NAME = "string_sensitive";

  public function getName() {
    return self::NAME;
  }

  public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
    return 'VARCHAR('.$fieldDeclaration['length'].') BINARY';
  }

  public function convertToPhpValue($value, AbstractPlatform $platform) {
    return $value;
  }

  public function convertToDatabaseValue($value, AbstractPlatform $platform) {
    return $value;
  }
}
