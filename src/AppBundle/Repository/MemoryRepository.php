<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

final class MemoryRepository extends EntityRepository {
  const pagesize = 30;

  public function __construct(EntityManagerInterface $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findMany($page, array $manufacturers = [], array $architectures = [], $size = null, $frequency = null) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['p'])
        ->from('AppBundle\Entity\Product\Memory', 'p')
        ->join('p.size', 's')
        ->join('p.frequency', 'f');

      if (count($manufacturers) > 0) {
        $builder->join('p.manufacturer', 'm', 'WITH', 'm.key IN (:manufacturers)')
          ->setParameter('manufacturers', array_map(function ($item) {
            return $item->toHex();
          }, $manufacturers));
      }

      if (count($architectures) > 0) {
        $builder->join('p.architecture', 'a', 'WITH', 'a.key IN (:architectures)')
          ->setParameter('architectures', array_map(function ($item) {
            return $item->toHex();
          }, $architectures));
      }
  
      $builder->orderby('p.id', 'ASC')
        ->setFirstResult($page * self::pagesize)
        ->setMaxResults(self::pagesize);
    }

    $results = $builder->getQuery()->getResult();

    {
      if ($size != null) {
        $results = array_filter($results, function ($item) use (&$size) {
          return !$item->getSize()->isGreaterThan($size->max)
            && !$item->getSize()->isLesserThan($size->min);
        });
      }

      if ($frequency != null) {
        $results = array_filter($results, function ($item) use (&$frequency) {
          return !$item->getFrequency()->isGreaterThan($frequency->max)
            && !$item->getFrequency()->isLesserThan($frequency->min);
        });
      }
    }

    return $results;
  }
  
  public function findByKey($key) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['p'])
        ->from('AppBundle\Entity\Product\Memory', 'p')
        ->where('p.key = ?1')
        ->setParameter(1, $key->toHex());
    }

    return $builder->getQuery()->getResult()[0];
  }
}
