<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\UrlKey;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ManufacturerRepository")
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Manufacturers_name", columns={ "name" }),
 *     @ORM\UniqueConstraint(name="UK_Manufacturers_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("key")
 * @UniqueEntity("name")
 */
class Manufacturer extends UrlKey {
  const name_length = 25;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=Manufacturer::name_length)
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
  
  public function __construct($name) {
    parent::__construct();
    $this->setName($name);
  }
}
