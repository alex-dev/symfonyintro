<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity
 * @ORM\Table
 * })
 */
class ProductTranslation {
  use Translation;
  
  const name_length = 255;

  /**
   * @ORM\Column(type="string", length=ProductTranslation::name_length)
   * @Assert\Length(max=ProductTranslation::name_length, maxMessage="product.name.toolong", groups={ "App" })
   * @Assert\NotBlank(message="product.name.blank", groups={ "App" })
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
