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
   * @ORM\Column(type="string", length=ArchitectureTranslation::abbreviation_length)
   */
  protected $abbreviation;  

  public function getAbbreviation() {
    return $this->abbreviation;
  }

  public function setAbbreviation($value) {
    if (mb_strlen($value) > self::abbreviation_length) {
      throw new LengthException("$value must be less then ".self::abbreviation_length." characters long.");
    } else {
      $this->abbreviation = $value;
    }
  }
}
