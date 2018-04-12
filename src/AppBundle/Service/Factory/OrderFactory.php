<?php
namespace AppBundle\Service\Factory;

use AppBundle\Entity\Order\OrderItem;
use AppBundle\Entity\Order\Order;
use AppBundle\Repository\ItemRepository;
use AppBundle\Service\CostCalculator;
use AppBundle\Service\Factory\AbstractFactory;

final class OrderFactory extends AbstractFactory {
  private $calculator;
  private $itemRepository;
  private $orderRepository;

  public function __construct(CostCalculator $calculator, ItemRepository $itemRepository, $orderRepository) {
    $this->calculator = $calculator;
    $this->itemRepository = $itemRepository;
    $this->orderRepository = $orderRepository;
  }

  public function __invoke(array $keys) { return $this->createFromSession($keys); }

  public function getFromRepositoryByKey($key) {
    $data = $this->orderRepository->findOneByKey($key->toHex());
    $data->setCalculator($this->calculator);
    return $data;
  }

  public function getFromRepositoryByClient(Client $client) {
    $data = $this->orderRepository->findByClient($client);
    array_walk($data, function ($item) { $item->setCalculator($this->calculator); });
    return $data;
  }

  public function createFromSession(array $keys) {
    if (count($keys > 0)) {
      $keys_ = array_map(function ($key) { return $key['key']; }, $keys);
      $combinedKeys = array_combine(
        $keys_, array_map(function ($item) { return $item['quantity']; }, $keys));
      $items = $this->itemRepository->findItemsCostProductByKeys($keys_);
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
