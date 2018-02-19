<?php
namespace AppBundle\CustomException;

use Zend\Code\Exception\RuntimeException;

class UnknowProductException extends RuntimeException {
  public function __construct($message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
