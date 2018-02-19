<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Manufacturers_name", columns={ "name" })
 *   })
 * @UniqueEntity("key")
 */
class Item extends UrlKey {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Product\Product",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $product;

  /**
   * @ORM\OneToOne(
   *   targetEntity="AppBundle\Entity\QuantityPattern\Scalar",
   *   orphanRemoval=true,
   *   cascade={ "persist", "refresh", "remove" })
   * @ORM\JoinColumn(nullable=false)
   */
  protected $cost;
}
