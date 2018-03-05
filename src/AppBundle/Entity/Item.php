<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Exception\UnitException;
use AppBundle\Service\Factory\DimensionsFactory;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Value\Scalar;

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

  protected function setProduct(Product $value) {
    $this->product = $value;
  }

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Value\Scalar",
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
  
  public function __construct(Product $product, Scalar $cost, $count, DimensionsFactory $factory) {
    $this->setProduct($product);
    $this->setCount($count);
    $this->setCost_($cost, $factory('cad'));
  }

  protected function setCost_(Scalar $value, $dimensions) {
    if ($value->getUnit()->getDimensions() != $dimensions) {
      throw new UnitException($value->getUnit()->getDimensions()." is not $dimensions.");
    } else {
      $this->cost = $value;
    }
  }
}
