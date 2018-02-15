<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Manufacturer;
use AppBundle\Entity\Product\ProductTranslation;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *   "memory" = "Memory"
 * })
 * @ORM\Table(
 *   name="Products",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Products_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
abstract class Product extends UrlKey {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(name="idProduct", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(name="code", type="string", length=50)
   */
  protected $code;

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Manufacturer",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(name="idManufacturer", referencedColumnName="idManufacturer", nullable=false)
   */
  protected $manufacturer;

  public function __construct(array $names, Manufacturer $manufacturer) {
    parent::__construct();
    $this-­­­­>setManufacturer($manufacturer);
    
    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }
  }

  public function __call($method, $arguments) {
    if (count($arguments) > 0 || !in_array($method, ['getName', 'setName'])) {
      throw new BadMethodCallException("$method is not supported by $this.");
    } else {
      return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
  }

  /**
   * @return Manufacturer
   */
  public function getManufacturer() {
    return $this->manufacturer;
  }

  /**
   * @return void
   */
  public function setManufacturer(Manufacturer $manufacturer) {
    $this->manufacturer = $manufacturer;
  }
}