<?php
namespace AppBundle\DataObject;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\CustomException\PasswordException;
use AppBundle\Entity\Client\Password;

class NewPassword extends Password {
  const length = 15;

  /**
   * @Assert\IdenticalTo(propertyPath="value", message="password.unconfirmed")
   */
  protected $confirm;
}