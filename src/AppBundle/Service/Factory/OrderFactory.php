<?php
namespace AppBundle\Service\Factory;

use AppBundle\DataObject\OrderItem;
use AppBundle\DataObject\Order;
use AppBundle\Repository\ItemRepository;
use AppBundle\Service\CostCalculator;
use AppBundle\Service\Factory\AbstractFactory;

final class OrderFactory extends AbstractFactory {
  private $calculator;
  private $repository;

  public function __construct(CostCalculator $calculator, ItemRepository $repository) {
    $this->calculator = $calculator;
    $this->repository = $repository;
  }

  public function __invoke(array $keys) {
    if (count($keys > 0)) {
      $keys_ = array_map(function ($key) { return $key['key']; }, $keys);
      $combinedKeys = array_combine(
        $keys_, array_map(function ($item) { return $item['quantity']; }, $keys));
      $items = $this->repository->findItemsCostProductByKeys($keys_);
      $combinedItems = array_combine(array_map(function ($item) {
        return $item->getProduct()->getKey();
      }, $items), $items);
  
      return new Order(
        array_map(function ($item, $quantity) {
          return new OrderItem($item->getProduct(), $item->getCost(), $quantity);
        }, array_values($combinedItems), array_values($combinedKeys)),
        $this->calculator);
    } else {
      return new Order([], $this->calculator);
    }
  }
}
