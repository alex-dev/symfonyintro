<?php
namespace AppBundle\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Order\Order;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Value\Scalar;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_OrderItems_product_order", columns={ "product", "order" })
 *   })
 * @UniqueEntity("product", "order")
 */
class OrderItem {
  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
   * @ORM\JoinColumn(name="order", referencedColumnName="id")
   */
  protected $order;

  public function getOrder() {
    return $this->order;
  }

  public function setOrder(Order $value) {
    $this->order = $value;
  }

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product\Product")
   */
  protected $product;

  public function getProduct() {
    return $this->product;
  }

  protected function setProduct(Product $value) {
    $this->product = $value;
  }

  /**
   * @ORN\Column(type="int", options={ "unsigned": true})
   */
  protected $quantity;
  
  public function getQuantity() {
    return $this->quantity;
  }

  public function setQuantity($value) {
    $this->quantity = $value;
  }
  
  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Value\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   */
  protected $cost;

  public function getCost() {
    return $this->cost;
  }

  protected function setCost(Scalar $value) {
    if ($value->getUnit()->getDimensions() != $this->getCost()->getDimensions()) {
      throw new UnitException($value->getUnit()->getDimensions().' is not '.$this->getCost()->getDimensions().'.');
    } else {
      $this->cost = $value;
    }
  }
  
  public function __construct(Product $product, Scalar $cost, $quantity) {
    $this->setQuantity($quantity);
    $this->setProduct($product);
    $this->cost = $cost;
  }
}
