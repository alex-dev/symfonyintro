<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discriminator", type="string", length=20)
 * @DiscriminatorMap({
 *   "memory" = "Memory"
 * })
 * @Table(
 *   name="Products",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_Products_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("`key`")
 */
class Product extends UrlKey {
  use Translatable;

  /**
   * @Id
   * @Column(name="idProduct", type="bigint", options={ "unsigned":true })
   * @GeneratedValue
   */
  protected $id;

  /**
   * @ManyToOne(targetEntity="Manufacturer", cascade={ "persist", "refresh" })
   * @JoinColumn(name="idManufacturer", referencedColumnName="idManufacturer")
   * @Assert\NotNull()
   * @Assert\Valid()
   */
  protected $manufacturer;

  public function __construct() {
    parent::__construct();    
  }

  /**
   * @return AppBundle\Entity\Manufacturer
   */
  public function getManufacturer() {
    return $this->manufacturer;
  }

  /**
   * @return void
   */
  public function setManufacturer(Manufacturer $manufacturer) {
    $this->manufacturer = $manufacturer;
  }
}