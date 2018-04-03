<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Email {
  const length = 100;

  /**
   * @ORM\Column(type="string", length=Email::length)
   * @Assert\Email(message="email.invalid")
   * @Assert\NotBlank(message="email.blank")
   */
  protected $value;

  public function __toString() {
    return $this->value;
  }
}