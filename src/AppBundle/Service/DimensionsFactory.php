<?php
namespace AppBundle\Service;

use AppBundle\Entity\QuantityPattern\Unit\Dimension;
use AppBundle\Entity\QuantityPattern\Unit\Unit;
use AppBundle\Repository\UnitRepository;
use AppBundle\Service\Factory\AbstractFactory;

final class DimensionsFactory extends AbstractFactory {
  private $repository;

  public function __construct(UnitRepository $repository) {
    $this->repository = $repository;
  }

  /**
   * @return array<Dimension> representing Dimension combination
   */
  public function __invoke($value) {
    return $this->repository->findBy(['`key`'=>$value])->getDimensions();
  }
}
