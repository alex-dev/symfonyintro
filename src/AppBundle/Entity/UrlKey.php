<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Database\Type\UUIDType;
use App\Type\UUID;

/**
 * @MappedSuperclass
 */
abstract class UrlKey {
  /**
   * @Column(name="`key`", type="uuid_binary")
   * @Assert\UUID(strict=true)
   * @Assert\NotNull()
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
