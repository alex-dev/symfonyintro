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
   * @Assert\Length(min=2, max=15, minMessage="firstname.tooshort", maxMessage="firstname.toolong")
   * @Assert\NotBlank(message="firstname.blank")
   */
  protected $firstName;

  public function getFirst() {
    return $this->firstName;
  }

  /**
   * @ORM\Column(type="string", length=Name::name_length)
   * @Assert\Length(min=2, max=15, minMessage="lastname.tooshort", maxMessage="lastname.toolong")
   * @Assert\NotBlank(message="lastname.blank")
   */
  protected $lastName;

  public function getLast() {
    return $this->lastName;
  }
}