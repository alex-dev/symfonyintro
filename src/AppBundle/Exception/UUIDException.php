<?php
namespace AppBundle\Exception;

class UUIDException extends Exception {
  public function __construct($message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
