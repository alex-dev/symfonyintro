<?php
namespace AppBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\Repository\ProductRepository;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Manufacturer;
use AppBundle\Entity\Image;
use AppBundle\Entity\Product\ProductTranslation;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=50)
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Products_key", columns={ "`key`" }),
 *     @ORM\UniqueConstraint(name="UK_Products_code_manufacturer", columns={ "code", "manufacturer" })
 *   })
 * @UniqueEntity("`key`")
 * @UniqueEntity(fields={ "code", "manufacturer" })
 */
abstract class Product extends UrlKey {
  use Translatable;

  const code_length = 50;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=Product::code_length)
   */
  protected $code;

  public function getCode() {
    return $this->code;
  }

  private function setCode($value) {
    $this->code = $value;
  }

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Manufacturer",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $manufacturer;

  public function getManufacturer() {
    return $this->manufacturer;
  }

  public function setManufacturer(Manufacturer $manufacturer) {
    $this->manufacturer = $manufacturer;
  }

  /**
   * @ORM\OneToMany(
   *   targetEntity="AppBundle\Entity\Image",
   *   mappedBy="product")
   */
  protected $images;
  
  public function getImages() {
    return $this->images;
  }

  public function setImages(array $value) {
    $this->images = new ArrayCollection($value);
  }

  public function getMainImage() {
    return $this->getImages()->filter(function ($item) {
      return $item->isMain();
    })[0];
  }

  public function getName($locale) {
    return $this->translate($locale)->getName();
  }

  private function setName($value, $locale) {
    return $this->translate($locale)->setName($value);
  }

  public function __construct($code, array $names, array $images, Manufacturer $manufacturer) {
    parent::__construct();
    $this->setImages($images);
    $this-­­­­>setManufacturer($manufacturer);
    $this->setCode($code);

    foreach ($names as $locale=>$name) {
      $this->setName($name, $locale);
    }
  }
}