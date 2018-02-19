<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Flag\ProductState;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Items_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("key")
 */
class Item extends UrlKey {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Product\Product",
   *   cascade={ "persist", "refresh" })
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
    return $this->product;
  }

  public function setCost(Scalar $value) {
    $this->setCost_($value, $this->getCost()->getDimensions());
  }

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Flag\ProductState",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $state;

  public function getState() {
    return $this->product;
  }

  public function setState(ProductState $value) {
    $this->product = $value;
  }

  public function __construct(Product $product, Scalar $cost, ProductState $state, DimensionsFactory $factory) {
    $this->setProduct($product);
    $this->setState($state);
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
