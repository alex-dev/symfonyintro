<?php
namespace AppBundle\DataObject;

use AppBundle\Repository\OrderSerializer;
use AppBundle\Service\CostCalculator;
use AppBundle\Type\UUID;

class Order {
  protected $calculator;

  protected $items;

  public function getItems() {
    return $this->items;
  }

  protected function setItems(array $value) {
    $this->items = $value;
  }

  /**
   * @return ['cost', 'taxes', 'delivery']
   */
  public function getCost() {
    $temp = $this->calculator;
    return $temp($this->getItems());
  }

  public function __construct(array $items, CostCalculator $calculator) {
    $this->calculator = $calculator;
    $this->setItems($items);
  }
}

