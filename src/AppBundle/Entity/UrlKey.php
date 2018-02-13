<?php
namespace \AppBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use \AppBundle\Database\Type\UUIDType;
use \AppBundle\Type\UUID;

/**
 * @ORM\MappedSuperclass
 */
abstract class UrlKey {
  /**
   * @ORM\Column(name="`key`", type="uuid_binary")
   */
  protected $key;
  
  public function __construct() {
    $this->setKey(new UUID());
  }

  /**
   * @return AppBundle\Type\UUID castable to string
   */
  public function getKey() {
    return $this->key;
  }

  private function setKey(UUID $value) {
    $this->key = $value;
  }
}
