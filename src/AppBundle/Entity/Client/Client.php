<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User;
use AppBundle\CustomException\PhoneException;
use AppBundle\Entity\Client\Address;
use AppBundle\Entity\Client\Name;

/**
 * @ORM\Entity
 * @ORM\AttributeOverrides({
 *   @ORM\AttributeOverride(name="username", column=@ORM\Column(type="string", length=Client::username_length)),
 *   @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(name="username_canonical", type="string", length=Client::username_length, unique=true)),
 *   @ORM\AttributeOverride(name="username", column=@ORM\Column(type="string", length=Client::username_length))
 * })
 * @UniqueEntity("username")
 */
class Client extends User {
  const username_length = 15;
  const phone_length = 15;
  const phone_pattern = 
  "/(?:(?:\+1)|1)?[-( ]?\d{3}[-) ]?[2-9]\d{2}[- ]?\d{4}/";

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=Client::phone_length)
   * @Assert\Regex(
   *   pattern=Client::phone_pattern,
   *   message="phone.invalid",
   *   groups={ "App" })
   * @Assert\NotBlank(message="phone.blank", groups={ "App" })
   */
  protected $phone;

  public function getPhone() {
    return $this->phone;
  }

  public function setPhone($value) {
    $this->phone = $value;
  }

  /**
   * @ORM\Embedded(class="Name")
   * @Assert\Valid
   */
  protected $name;

  public function getName() {
    return $this->name;
  }

  public function setName(Name $value) {
    $this->name = $value;
  }

  /**
   * @ORM\Embedded(class="Address")
   * @Assert\Valid
   */
  protected $address;

  public function getAddress() {
    return $this->address;
  }

  public function setAddress(Address $value) {
    $this->address = $value;
  }

  public function __construct() {
    parent::__construct();
  }
}