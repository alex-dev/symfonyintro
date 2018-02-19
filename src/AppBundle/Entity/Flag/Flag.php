<?php
namespace AppBundle\Entity\Flag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Exception\UnitException;
use AppBundle\Service\DimensionsFactory;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\QuantityPattern\Scalar;

/**
 * @ORM\MappedSuperclass
 */
abstract class Flag extends UrlKey {
  const name_length = 128;

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=Flag::name_length)
   */
  protected $nameTranslationKey;

  public function getName() {
    return $this->translate()->getName();
  }

  public function __toString() {
    return $this->getName();
  }
}
