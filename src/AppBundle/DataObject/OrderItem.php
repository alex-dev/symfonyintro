<?php
namespace AppBundle\DataObject;

use AppBundle\Entity\QuantityPattern\Value\Scalar;
use AppBundle\Entity\Product\Product;

class OrderItem {
  protected $quantity;

  public function getQuantity() {
    return $this->quantity;
  }

  public function setQuantity($value) {
    $this->quantity = $value;
  }

  protected $product;

  public function getProduct() {
    return $this->product;
  }

  protected function setProduct(Product $value) {
    $this->product = $value;
  }

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
