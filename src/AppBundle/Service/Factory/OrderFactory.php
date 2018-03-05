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
    return new Order(
      array_map(function ($item) {
        return new OrderItem($item->getProduct(), $item->getCost());
      }, $this->repository->findItemsCostProductByKeys($keys)),
      $this->calculator);
  }
}
