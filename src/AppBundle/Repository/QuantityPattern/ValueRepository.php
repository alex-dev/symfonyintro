<?php
namespace AppBundle\Repository\QuantityPattern;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class ValueRepository extends EntityRepository {
  public function __construct(EntityManager $manager, ClassMetadata $class){
    parent::__construct($manager, $class);
  }
}
