<?php
namespace AppBundle\CustomException;

use Zend\Code\Exception\RuntimeException;

class PasswordException extends RuntimeException {
  public function __construct($message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
