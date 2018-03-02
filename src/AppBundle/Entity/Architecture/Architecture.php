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
 * @ORM\DiscriminatorColumn(name="discriminator", type="string", length=50)
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
  
  public function getName($locale) {
    return $this->translate($locale)->getName();
  }

  private function setName($value, $locale) {
    return $this->translate($locale)->setName($value);
  }

  public function getAbbreviation($locale) {
    return $this->translate($locale)->getAbbreviation();
  }

  private function setAbbreviation($value, $locale) {
    return $this->translate($locale)->setAbbreviation($value);
  }

  public function __construct(array $names, array $abbreviations) {
    parent::__construct();

    foreach ($names as $locale=>$name) {
      $this->setName($name, $locale);
    }

    foreach ($abbreviations as $locale=>$abbreviation) {
      $this->setName($abbreviation, $locale);
    }
  }
}
