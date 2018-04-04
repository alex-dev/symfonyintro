<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Name {
  const name_length = 15;

  /**
   * @ORM\Column(type="string", length=Name::name_length)
   * @Assert\Length(min=2, max=15, minMessage="firstname.tooshort", maxMessage="firstname.toolong", groups={ "App" })
   * @Assert\NotBlank(message="firstname.blank", groups={ "App" })
   */
  protected $firstName;

  public function getFirstName() {
    return $this->firstName;
  }

  public function setFirstName($value) {
    $this->firstName = $value;
  }

  /**
   * @ORM\Column(type="string", length=Name::name_length)
   * @Assert\Length(min=2, max=15, minMessage="lastname.tooshort", maxMessage="lastname.toolong", groups={ "App" })
   * @Assert\NotBlank(message="lastname.blank", groups={ "App" })
   */
  protected $lastName;

  public function getLastName() {
    return $this->lastName;
  }

  public function setLastName($value) {
    $this->lastName = $value;
  }
}