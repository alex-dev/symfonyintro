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
}
