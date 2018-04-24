<?php
namespace AppBundle\Service\Factory;

use AppBundle\Entity\Client\Client;
use AppBundle\Entity\Order\OrderItem;
use AppBundle\Entity\Order\Order;
use AppBundle\Entity\Order\State;
use AppBundle\Entity\QuantityPattern\Value\Scalar;
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

  public function __invoke(array $keys, $client) { return $this->createFromSession($keys, $client); }

  public function getFromRepositoryByKey($key) {
    $data = $this->orderRepository->findOneByKey($key);
    $data->setCalculator($this->calculator);
    return $data;
  }

  public function getFromRepositoryByClient(Client $client) {
    $data = $this->orderRepository->findBy(['client' => $client, 'state' => State::valid], ['date' => 'DESC']);
    array_walk($data, function ($item) { $item->setCalculator($this->calculator); });
    return $data;
  }

  public function createFromSession(array $keys, $client) {
    if (count($keys > 0)) {
      $keys_ = array_map(function ($key) { return $key['key']; }, $keys);
      $combinedKeys = array_combine(
        $keys_, array_map(function ($item) { return $item['quantity']; }, $keys));
      $items = $this->itemRepository->findItemsByProductKeys($keys_);
      $combinedItems = array_combine(array_map(function ($item) {
        return $item->getProduct()->getKey();
      }, $items), $items);
  
      return new Order(
        array_map(function ($key) use ($combinedItems, $combinedKeys) {
          $item = $combinedItems[$key->toString()];
          $cost = new Scalar($item->getCost()->getUnit(), $item->getCost()->getValue());
          return new OrderItem($item->getProduct(), $cost, $combinedKeys[$key->toString()]);
        }, $keys_),
        $client,
        $this->calculator);
    } else {
      return new Order([], $this->calculator);
    }
  }
}
