<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @Entity
 * @Table(
 *   name="ArchitectureTranslations"
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_ArchitectureTranslations_name_locale", columns={ "name", "locale" }),
 *     @UniqueConstraint(name="UK_ArchitectureTranslations_abbreviation_locale", columns={ "abbreviation", "locale" })
 *   })
 * @UniqueEntity(fields={ "name", "locale" })
 * @UniqueEntity(fields={ "abbreviation", "locale" })
 */
class ArchitectureTranslation {
  use Translation;
  
  const name_length = 255;
  const abbreviation_length = 10;  

  /**
   * @Column(name="name", type="string", length=ArchitectureTranslation::name_length)
   * @Assert\Length(max=ArchitectureTranslation::name_length)
   * @Assert\NotBlank()
   */
  protected $name;

  /**
   * @Column(name="abbreviation", type="string", length=Architecture::abbreviation_length)
   * @Assert\Length(max=Architecture::abbreviation_length)
   * @Assert\NotBlank()
   */
  protected $abbreviation;  

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return void
   * @throws LengthException if $value is longer than self::name_length
   */
  public function setName(string $value) {
    if (mb_strlen($value) > self::name_length) {
      throw new LengthException("$value must be less then ".self::name_length." characters long.");
    } else {
      $this->name = $value;
    }
  }

  /**
   * @return string
   */
  public function getAbbreviation() {
    return $this->abbreviation;
  }

  /**
   * @return void
   * @throws LengthException if $value is longer than self::abbreviation_length
   */
  public function setAbbreviation(string $value) {
    if (mb_strlen($value) > self::abbreviation_length) {
      throw new LengthException("$value must be less then ".self::abbreviation_length." characters long.");
    } else {
      $this->abbreviation = $value;
    }
  }
}
