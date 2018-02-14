<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Architecture\ArchitectureTranslation;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *   "graphic" = "GraphicAcceleratorArchitecture",
 *   "hard" = "HardDriveArchitecture",
 *   "memory" = "MemoryArchitecture",
 *   "processor" = "ProcessorArchitecture"
 * })
 * @ORM\Table(
 *   name="Architectures",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Manufacturers_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
abstract class Architecture extends UrlKey {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(name="idArchitecture", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;
  
  public function __construct(array $names, array $abbreviations) {
    parent::__construct();

    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }

    foreach ($abbreviations as $locale=>$abbreviation) {
      $this->translate($locale)->setName($abbreviation);
    }
  }

  public function __call($method, $arguments) {
    if (count($arguments) > 0 || !in_array($method, ['getName', 'getAbbreviation', 'setName', 'setAbbreviation'])) {
      throw new BadMethodCallException("$method is not supported by $this.");
    } else {
      return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
  }
}
