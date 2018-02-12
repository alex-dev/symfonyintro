<?php
namespace AppBundle\Entity\Architecture;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @DiscriminatorMap({
 *   "graphic" = "GraphicAcceleratorArchitecture",
 *   "hard" = "HardDriveArchitecture",
 *   "memory" = "MemoryArchitecture",
 *   "processor" = "ProcessorArchitecture"
 * })
 * @Table(
 *   name="Architectures",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_Manufacturers_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
class Architecture extends UrlKey {
  use Translatable;

  /**
   * @Id
   * @Column(name="idArchitecture", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  protected $id;
  
  public function __construct() {
    parent::__construct();    
  }
}
