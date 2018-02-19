<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Type\UUID;

/**
 * @ORM\MappedSuperclass
 */
abstract class UrlKey {
  /**
   * @ORM\Column(name="`key`", type="uuid_binary")
   */
  protected $key;

  public function getKey() {
    return $this->key;
  }

  private function setKey(UUID $value) {
    $this->key = $value;
  }
  
  public function __construct() {
    $this->setKey(new UUID());
  }
}
