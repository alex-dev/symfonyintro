<?php
namespace \AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="Images",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Images_filename", columns={ "filename" })
 *   })
 * @UniqueEntity("filename")
 */
class Image {
  const filename_length = 25;

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(name="idImage", type="bigint", options={ "unsigned": true })
   */
  protected $id;

  /**
   * @ORM\Column(name="filename", type="string", length=Image::filename_length)
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
