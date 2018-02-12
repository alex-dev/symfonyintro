<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
 * @Table(name="Memories")
 */
class Memory extends Product {
  /**
   * @Column(name="size", type="bigint", options={ "unsigned":true })
   * @Assert\NotNull()
   */
  protected $size;

  public function __construct() {
    parent::__construct();
  }

  /**
   * @return number
   */
  public function getSize() {
    return $this->size;
  }

  /**
   * @return string
   */
  public function getSizeStringify() {
    $this->size
  }
}
