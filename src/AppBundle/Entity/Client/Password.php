<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\CustomException\PasswordException;

/**
 * @ORM\Embeddable
 */
class Password {
  const length = 15;

  protected $salt;

  public function getSalt() {
    return $this->salt;
  }

  public function setSalt($value) {
    $this->salt = $value;
  }

  /**
   * @ORM\Column(type="string", length=Password::length)
   * @Assert\Length(min=2, max=15, minMessage="password.tooshort", maxMessage="password.toolong")
   * @Assert\NotBlank(message="password.blank")
   */
  protected $value;

  public function getPassword() {
    return $this->value;
  }

  public function setPassword($value) {
    $this->value = $value;
  }

  public function __construct($salt, $password) {
    $this->setSalt($salt);
    $this->setPassword($password);
  }
}