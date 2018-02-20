<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @ORM\Table
 */
class Item {
  /**
   * @ORM\Id
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\Product\Product",
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $product;

  public function getProduct() {
    return $this->product;
  }

  public function setProduct(Product $value) {
    $this->product = $value;
  }

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $cost;

  public function getCost() {
    return $this->cost;
  }

  public function setCost(Scalar $value) {
    $this->setCost_($value, $this->getCost()->getDimensions());
  }

  /**
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   */
  protected $count;

  public function getCount() {
    return $this->count;
  }

  public function setCount($value) {
    $this->count = $value;
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
  
  public function __construct(Product $product, Scalar $cost, $count, DimensionsFactory $factory) {
    $this->setProduct($product);
    $this->setCount($count);
    $this->setCost_($size, $factory('cad'));
  }

  protected function setCost_(Scalar $value, $dimensions) {
    if ($value->getUnit()->getDimensions() != $dimensions) {
      throw new UnitException($value->getUnit()->getDimensions()." is not $dimensions.");
    } else {
      $this->cost = $value;
    }
  }
}
