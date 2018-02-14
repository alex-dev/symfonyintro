<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Architecture\ArchitectureTranslation;


/**
 * @ORM\Entity
 * @ORM\Table(name="ECCs"))
 */
class ECC extends UrlKey {
  /**
   * @ORM\Id
   * @ORM\Column(name="idECC", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  public function __construct(array $names) {
    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }
  }

  public function __call($method, $arguments) {
    if (count($arguments) > 0 || !in_array($method, ['getName', 'setName'])) {
      throw new BadMethodCallException("$method is not supported by $this.");
    } else {
      return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
  }
}
