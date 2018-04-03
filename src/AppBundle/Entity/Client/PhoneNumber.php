<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class PhoneNumber {
  const length = 15;

  /**
   * @ORM\Column(type="string", length=PhoneNumber::length)
   * @Assert\Regex(
   *   pattern="/(?:(?:+1)|1)?[(- ]?\d{3}[)- ]?[2-9]\d{2}[- ]?\d{4}/",
   *   message="phone.invalid")
   * @Assert\NotBlank(message="phone.blank")
   */
  protected $value;

  public function __toString() {
    return $this->value;
  }
}