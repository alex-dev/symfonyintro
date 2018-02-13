<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Entity
 * @Table(
 *   name="Images",
 *   uniqueConstraints={
 *     @UniqueConstraint(name="UK_Images_filename", columns={ "filename" })
 *   })
 * @UniqueEntity("filename")
 */
class Image {
  const filename_length = 25;

  /**
   * @Id
   * @GeneratedValue
   * @Column(name="idImage", type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @Column(name="filename", type="string", length=Image::filename_length)
   */
  protected $filename;

  public function __construct(string $filename) {
    $this->setFilename($filename);
  }

  /**
   * @return string
   */
  public function getFilename() {
    return $this->filename;
  }

  /**
   * @return void
   */
  protected function setFilename(string $value) {
    if (mb_strlen($value) > self::filename_length) {
      throw new LengthException("$value must be less then ".self::filename_length." characters long.");
    } else {
      $this->filename = $value;
    }
  }
}
