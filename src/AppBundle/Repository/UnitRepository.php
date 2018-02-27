<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

final class UnitRepository extends EntityRepository {
  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';
  const moneyConverter = 'AppBundle\Entity\QuantityPattern\Unit\Converter\MoneyConverter';

  public function __construct(EntityManagerInterface $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findCurrencies() {
    $builder = $this->getEntityManager()->createQueryBuilder();
    
    {
      $builder->select(['u'])
        ->from(self::unit, 'u')
        ->join('u.converter', 'c', 'WITH', 'c IS INSTANCEOF '.self::moneyConverter);
    }

    return $builder->getQuery()->getResult();
  }
}
