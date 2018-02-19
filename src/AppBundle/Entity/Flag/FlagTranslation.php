<?php
namespace AppBundle\Entity\Flag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={
 *   @ORM\UniqueConstraint(name="UK_FlagTranslations_name_locale", columns={ "name", "locale" })
 * })
 */
class FlagTranslation {
  use Translation;
  
  const name_length = 128;

  /**
   * @ORM\Column(type="string", length=FlagTranslation::name_length)
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
}
