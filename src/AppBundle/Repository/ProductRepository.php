<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use AppBundle\Type\UUID;

final class ProductRepository extends EntityRepository {
  const pagesize = 30;

  public function __construct(EntityManagerInterface $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findMany($page, array $manufacturers = []) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['p'])
        ->from('AppBundle\Entity\Product\Product', 'p');

      if (count($manufacturers) > 0) {
        $builder->join('p.manufacturer', 'm', 'WITH', 'm.key IN (:manufacturers)')
          ->setParameter('manufacturers', array_map(function ($item) {
            return $item->toHex();
          }, $manufacturers));
      }

      $builder->orderby('p.id', 'ASC')
        ->setFirstResult($page * self::pagesize)
        ->setMaxResults(self::pagesize);
    }

    return $builder->getQuery()->getResult();
  }
}
