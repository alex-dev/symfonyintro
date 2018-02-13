<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

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
class Architecture extends UrlKey {
  use Translatable;

  /**
   * @ORM\Id
   * @ORM\Column(name="idArchitecture", type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;
  
  public function __construct() {
    parent::__construct();    
  }
}
