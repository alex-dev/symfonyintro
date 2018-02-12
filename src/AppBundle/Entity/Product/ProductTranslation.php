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
 *   name="ProductTranslations"
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_ProductTranslations_name_locale", columns={ "name", "locale" })
 *   })
 * @UniqueEntity(fields={ "name", "locale" })
 */
class ProductTranslation {
  use Translation;
  
  const name_length = 255;

  /**
   * @Column(name="name", type="string", length=ProductTranslation::name_length)
   * @Assert\Length(max=ProductTranslation::name_length)
   * @Assert\NotBlank()
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
