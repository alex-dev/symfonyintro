<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="ProductTranslations"
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_ProductTranslations_name_locale", columns={ "name", "locale" })
 *   })
 * @UniqueEntity(fields={ "name", "locale" })
 */
class ProductTranslation {
  use Translation;
  
  const name_length = 255;

  /**
   * @ORM\Column(name="name", type="string", length=ProductTranslation::name_length)
   */
  protected $name;

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
}
