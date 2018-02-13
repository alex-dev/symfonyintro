<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Entity
 * @Table(
 *   name="Manufacturers",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_Manufacturers_name", columns={ "name" }),
 *     @UniqueConstraint(name="UK_Manufacturers_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("key")
 * @UniqueEntity("name")
 */
class Manufacturer extends UrlKey {
  const name_length = 25;

  /**
   * @Id
   * @Column(name="idManufacturer", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  protected $id;

  /**
   * @Column(name="name", type="string", length=Manufacturer::name_length)
   */
  protected $name;
  
  public function __construct(string $name) {
    parent::__construct();
    $this->setName($name);
  }

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
