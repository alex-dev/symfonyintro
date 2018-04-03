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

  /**
   * @Assert\IdenticalTo(propertyPath="value", message="password.unconfirmed")
   */
  protected $confirm;

  public function getPassword() {
    if ($this->value === $this->confirm || $this->confirm == null) {
      return $this->value;
    } else {
      throw new PasswordException();
    }
  }

  public function setPassword($value) {
    $this->value = $value;
  }

  public function __construct($salt, $password, $confirm = null) {
    $this->setSalt($salt);
    $this->setPassword($password);
    $this->confirm = $confirm;
  }
}