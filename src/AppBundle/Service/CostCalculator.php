<?php
namespace AppBundle\Service;

use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Value\Scalar;
use AppBundle\Repository\ItemRepository;

final class CostCalculator {
  private $defaultUnit;

  public function __construct($unit) {
    $this->defaultUnit = $unit;
  }

  /**
   * @return Scalar
   * 
   * This class can be easily extended to calculate price including various
   * reduction depending on the user or databse without ever modifying items
   * and products themselves.
   */
  public function __invoke(array $items, $user = null) {
    $data = $this->calculate($items);
    $data['total'] = $data['cost']->add($data['shipping'])
      ->add($this->reduceScalars($data['taxes'], function ($tax) { return $tax; }));

    return $data;
  }

  private function calculate(array $items) {
    $cost = $this->reduceScalars($items, function ($item) {
      return $item->getCost()->multiplyByConstant($item->getQuantity());
    });
   
    return [
      'cost' => $cost,
      'shipping' => new Scalar($this->defaultUnit, 0),
      'taxes' => [
        'TPS' => $cost->multiplyByConstant(0.05),
        'TVQ' => $cost->multiplyByConstant(0.09975)
      ]
    ];
  }

  private function reduceScalars(array $arr, callable $getData) {
    return !count($arr) ? new Scalar($this->defaultUnit, 0) : array_reduce(
      $arr,
      function ($carry, $data) use ($getData) { 
        return $carry->add($getData($data)); 
      }, 
      new Scalar($this->defaultUnit, 0));
  }
}
