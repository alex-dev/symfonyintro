<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use 

/**
 * @Entity
 * @Table(name="Memories")
 */
class Memory extends Product {
  /**
   * @ORM\Column
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
