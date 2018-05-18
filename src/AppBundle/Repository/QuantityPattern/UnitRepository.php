<?php
namespace AppBundle\Repository\QuantityPattern;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class UnitRepository extends EntityRepository {
  const moneyConverter = 'AppBundle\Entity\QuantityPattern\Converter\MoneyConverter';

  public function __construct(EntityManager $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findByKey($key) {
    return $this->createQueryBuilder('u')
      ->where('u.key = :key')
      ->setParameters('key', $key)
      ->getQuery()->getResult();
  }

  public function findCurrencies() {
    return $this->createQueryBuilder('u')
      ->join('u.converter', 'c', 'WITH', 'c INSTANCE OF '.self::moneyConverter)
      ->getQuery()->getResult();
  }

  public function findSimilar($dimensions) {
    return array_filter(
      $this->createQueryBuilder('u')
        ->join('u.dimensions', 'd', 'WITH', 'd IN :dimensions')
        ->setParameters('dimensions', $dimensions)
        ->getQuery()->getResult(),
      function ($unit) use ($dimensions) {
        return count(array_diff($dimensions, $unit->getDimensions())) <= 0
          && count(array_diff($unit->getDimensions(), $dimensions)) <= 0;
      });
  }
}
