<?php
namespace AppBundle\DataObject;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use AppBundle\DataObject\NewPassword;

class ChangePassword extends NewPassword {
  /**
   * @SecurityAssert\UserPassword(message="password.old.wrong")
   */
  protected $old;
}