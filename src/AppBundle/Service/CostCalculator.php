<?php
namespace AppBundle\Service;

use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Value\Scalar;
use AppBundle\Repository\ItemRepository;

final class CostCalculator {
  /**
   * @return Scalar
   * 
   * This class can be easily extended to calculate price including various
   * reduction depending on the user or databse without ever modifying items
   * and products themselves.
   */
  public function __invoke(array $items, $user = null) {
    $cost = array_reduce(
      array_slice($items, 1),
      function ($carry, $item) { return $carry->add($item->getCost()); },
      $items[0]->getCost());
    $shipping = new Scalar($items[0]->getCost()->getUnit(), 0);
    $taxes = [
      'TPS' => $cost->multiplyByConstant(0.05),
      'TVQ' => $cost->multiplyByConstant(0.09975)
    ];

    return [
      'cost' => $cost,
      'shipping' => $shipping,
      'taxes' => $taxes,
      'total' => $cost->add($shipping)->add(array_reduce(
        $taxes,
        function ($carry, $item) { return $carry->add($item); },
        new Scalar($items[0]->getCost()->getUnit(), 0)))
    ];
  }
}
