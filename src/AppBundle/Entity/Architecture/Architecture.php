<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Architecture\ArchitectureTranslation;

// All currently inserted data are UDIMM

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
 * @ORM\Table(uniqueConstraints={ @ORM\UniqueConstraint(name="UK_Architectures_key", columns={ "`key`" }) })
 * @UniqueEntity("`key`")
 */
abstract class Architecture extends UrlKey {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;
  
  public function getName() {
    return $this->translate()->getName();
  }

  public function getAbbreviation() {
    return $this->translate()->getAbbreviation();
  }

  public function __construct(array $names, array $abbreviations) {
    parent::__construct();

    foreach ($names as $locale=>$name) {
      $this->translate($locale)->setName($name);
    }

    foreach ($abbreviations as $locale=>$abbreviation) {
      $this->translate($locale)->setName($abbreviation);
    }
  }
}
