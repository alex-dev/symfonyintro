<?php
namespace AppBundle\Entity\QuantityPattern\Unit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={
 *   @ORM\UniqueConstraint(name="UK_QuantityUnitTranslations_name_locale", columns={ "name", "locale" }),
 *   @ORM\UniqueConstraint(name="UK_QuantityUnitTranslations_symbol_locale", columns={ "symbol", "locale" })
 * })
 * @UniqueEntity(fields={ "name", "locale" })
 * @UniqueEntity(fields={ "symbol", "locale" })
 */
class UnitTranslation {
  use Translation;

  const name_length = 50;
  const symbol_length = 5;

  /**
   * @ORM\Column(type="string", length=UnitTranslation::name_length)
   */
  private $name;

  public function getName() {
    return $this->name;
  }

  public function setName($value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }

  /**
   * @ORM\Column(type="string_sensitive", length=UnitTranslation::symbol_length)
   */
  private $symbol;

  public function getSymbol() {
    return $this->symbol;
  }

  public function setSymbol($value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }
}
