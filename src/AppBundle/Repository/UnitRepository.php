<?php
namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class UnitRepository extends EntityRepository {
  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';
  const moneyConverter = 'AppBundle\Entity\QuantityPattern\Unit\Converter\MoneyConverter';

  public function __construct(EntityManager $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findCurrencies() {
    $builder = $this->getEntityManager()->createQueryBuilder();
    
    {
      $builder->select(['u'])
        ->from(self::unit, 'u')
        ->join('u.converter', 'c', 'WITH', 'c INSTANCE OF '.self::moneyConverter);
    }

    return new ArrayCollection($builder->getQuery()->getResult());
  }
}
