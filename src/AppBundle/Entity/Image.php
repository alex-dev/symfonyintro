<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Images_filename", columns={ "filename" }),
 *     @ORM\UniqueConstraint(name="UK_Images_product_main", columns={ "product", "main" })
 *   })
 * @UniqueEntity("filename")
 * @UniqueEntity(fields={ "product", "main" })
 */
class Image {
  const filename_length = 50;

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @ORM\ManyToOne(
   *   targetEntity="AppBundle\Entity\Product\Product",
   *   inversedBy="images",
   *   cascade={ "persist", "refresh" })
   * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
   */
  protected $product;
  
  public function setProduct($product) {
    $this->product = $product;
  }

  /**
   * @ORM\Column(type="string", length=Image::filename_length)
   */
  protected $filename;

  public function getFilename() {
    return $this->filename;
  }

  public function setFilename($value) {
    $this->filename = $value;
  }

  /**
   * @ORM\Column(type="boolean")
   */
  protected $main;

  public function isMain() {
    return $this->main;
  }

  public function getIsMain() {
    return $this->main;
  }

  public function setIsMain($value) {
    $this->main = $value;
  }

  public function __construct($filename = '', $isMain = false) {
    $this->setFilename($filename);
    $this->setIsMain($isMain);
  }

  public function __toString() {
    return $this->getFilename();
  }
}
