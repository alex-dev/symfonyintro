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

  public function findCurrencies() {
    $builder = $this->createQueryBuilder('u')
      ->join('u.converter', 'c', 'WITH', 'c INSTANCE OF '.self::moneyConverter);

    return $builder->getQuery()->getResult();
  }
}
