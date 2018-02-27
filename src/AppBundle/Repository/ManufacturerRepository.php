<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

final class ManufacturerRepository extends EntityRepository {
  const manufacturer = 'AppBundle\Entity\Manufacturer';

  public function __construct(EntityManagerInterface $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }
  
  public function findManufacturerFor($product) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['m'])
        ->from(self::manufacturer, 'm')
        ->join($product, 'p', 'WITH', 'p.manufacturer = m.id');
    }

    return $builder->getQuery()->getResult();
  }
}
