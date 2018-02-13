<?php
namespace \AppBundle\Entity\QuantityPattern\Unit;

use \Doctrine\ORM\Mapping as ORM;
use \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="QuantityUnitTranslations",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_QuantityUnitTranslations_name_locale", columns={ "name", "locale" })
 *     @ORM\UniqueConstraint(name="UK_QuantityUnitTranslations_symbol_locale", columns={ "symbol" })
 *   })
 * @UniqueEntity("name", "locale")
 * @UniqueEntity("symbol", "locale")
 */
final class UnitTranslation {
  use Translation;

  const name_length = 50;
  const symbol_length = 5;

  /**
   * @ORM\Column(name="name", type="string", length=Dimension::name_length)
   */
  private $name;

  /**
   * @ORM\Column(name="symbol", type="string", length=Dimension::symbol_length)
   */
  private $symbol;

  public function getName() {
    return $this->name;
  }

  public function getSymbol() {
    return $this->symbol;
  }

  private function setName(string $value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }

  private function setSymbol(string $value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }
}
