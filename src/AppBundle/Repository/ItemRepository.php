<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use AppBundle\Entity\Product\Product;
use AppBundle\Type\UUID;

final class ItemRepository extends EntityRepository {
  const pagesize = 30;

  public function __construct(EntityManagerInterface $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }

  public function findByKey($key) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['i', 'p', 'c'])
        ->from('AppBundle\Entity\Item', 'i')
        ->join('i.product', 'p')
        ->join('i.cost', 'c')
        ->where('p.key = ?1')
        ->setParameter(1, $key->toHex());
    }

    return $builder->getQuery()->getResult()[0];
  }

  public function findMany($page, array $manufacturers = []) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['i', 'p', 'c'])
        ->from('AppBundle\Entity\Item', 'i')
        ->join('i.product', 'p')
        ->join('i.cost', 'c');

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

  public function findManyMemories($page, array $manufacturers = [], array $architectures = [], $size = null, $frequency = null) {
    $builder = $this->getEntityManager()->createQueryBuilder();

    {
      $builder->select(['i', 'c'])
        ->from('AppBundle\Entity\Item', 'i')
        ->join('AppBundle\Entity\Product\Memory', 'p', 'WITH', 'i.product = p.id')
        ->join('i.cost', 'c')
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
          return !$item->getProduct()->getSize()->isGreaterThan($size->max)
            && !$item->getProduct()->getSize()->isLesserThan($size->min);
        });
      }

      if ($frequency != null) {
        $results = array_filter($results, function ($item) use (&$frequency) {
          return !$item->getProduct()->getFrequency()->isGreaterThan($frequency->max)
            && !$item->getProduct()->getFrequency()->isLesserThan($frequency->min);
        });
      }
    }

    return $results;
  }

/////////////////////////////
 /* public function findItemCostProductByKey(UUID $key) {
    return $this->createQueryBuilder('i')
    ->addSelect('c')->join('i.cost', 'c')
    ->addSelect('p')->join('i.product', 'p', 'WITH', 'p.key = :key')
    ->setParameter('key', $key->toHex())
    ->getQuery()->getResult();
  }*/
  
  public function findItemsByProductKeys(array $keys) {
    return $this->createQueryBuilder('i')
      ->addSelect('c')->join('i.cost', 'c')
      ->addSelect('u')->join('c.unit', 'u')
      ->addSelect('p')->join('i.product', 'p', 'WITH', 'p.key IN (:keys)')
      ->setParameter(
        'keys',
        array_map(function (UUID $key) { return $key->toHex(); }, $keys))
      ->getQuery()->getResult();
  }
}
