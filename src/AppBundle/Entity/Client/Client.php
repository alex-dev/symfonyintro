<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Client\Address;
use AppBundle\Entity\Client\Email;
use AppBundle\Entity\Client\Name;
use AppBundle\Entity\Client\PhoneNumber;
use AppBundle\Entity\Client\Password;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Clients_username", columns={ "username" })
 *   })
 * @UniqueEntity("username")
 */
class Client implements EquatableInterface, UserInterface, \Serializable{
  const username_length = 15;

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=Client::username_length)
   * @Assert\Length(min=2, max=15, minMessage="username.tooshort", maxMessage="username.toolong")
   * @Assert\NotBlank(message="username.blank")
   */
  protected $username;

  public function getUsername() {
    return $this->username;
  }

  /**
   * @ORM\Embedded(class="Password")
   * @Assert\Valid
   */
  protected $password;

  public function getPassword() {
    if ($this->password == null) {
      return null;
    } else {
      return $this->password->getPassword();
    }
  }

  public function getSalt() {
    if ($this->password == null) {
      return null;
    } else {
      return $this->password->getSalt();
    }
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @ORM\Embedded(class="Email")
   * @Assert\Valid
   */
  protected $email;

  public function getEmail() {
    return $this->email;
  }

  /**
   * @ORM\Embedded(class="PhoneNumber")
   * @Assert\Valid
   */
  protected $phone;

  public function getPhone() {
    return $this->phone;
  }

  /**
   * @ORM\Embedded(class="Name")
   * @Assert\Valid
   */
  protected $name;

  public function getName() {
    return $this->name;
  }

  /**
   * @ORM\Embedded(class="Address")
   * @Assert\Valid
   */
  protected $address;

  public function getAddress() {
    return $this->address;
  }

  public function getRoles() {
    return ['ROLE_USER'];
  }

  public function eraseCredentials() { }

  public function isEqualTo(UserInterface $user) {
    return $this->getUsername() == $user->getUsername()
      && $this->getPassword() == $user->getPassword()
      && $this->getSalt() == $user->getSalt();
  }

  public function __construct() {
    $this->address = new Address();
    $this->email = new Email();
    $this->name = new Name();
    $this->phone = new PhoneNumber();
    $this->password = new Password(null, null);
  }

  public function serialize()
  {
    return serialize([
      $this->id,
      $this->getUsername(),
      $this->getPassword(),
      $this->getSalt(),
    ]);
  }

  public function unserialize($serialized)
  {
    list (
      $this->id,
      $this->username,
      $password,
      $salt
    ) = unserialize($serialized);
    $this->password = new Password($salt, $password);
  }
}