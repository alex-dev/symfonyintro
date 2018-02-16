<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={
 *   @ORM\UniqueConstraint(name="UK_ArchitectureTranslations_name_locale", columns={ "name", "locale" })
 * })
 */
class ArchitectureTranslation {
  use Translation;
  
  const name_length = 255;
  const abbreviation_length = 10;  

  /**
   * @ORM\Column(type="string", length=ArchitectureTranslation::name_length)
   */
  protected $name;

  /**
   * @ORM\Column(type="string", length=ArchitectureTranslation::abbreviation_length)
   */
  protected $abbreviation;  

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getAbbreviation() {
    return $this->abbreviation;
  }

  /**
   * @return void
   * @throws LengthException if $value is longer than self::name_length
   */
  public function setName($value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }

  /**
   * @return void
   * @throws LengthException if $value is longer than self::abbreviation_length
   */
  public function setAbbreviation($value) {
    if (mb_strlen($value) > self::abbreviation_length) {
      throw new LengthException("$value must be less then ".self::abbreviation_length." characters long.");
    } else {
      $this->abbreviation = $value;
    }
  }
}
