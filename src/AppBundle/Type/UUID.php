<?php
namespace AppBundle\Type;

use Serializable;
use AppBundle\CustomException\UUIDException;

final class UUID {
  const pattern = '^{?((?:[0-9A-F]{8}-[0-9A-F]{4}-[1-5][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})|(?:[0-9A-F]{12}[1-5][0-9A-F]{3}[89AB][0-9A-F]{15}))}?$';
  const regex = '/^{?((?:[0-9A-F]{8}-[0-9A-F]{4}-[1-5][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})|(?:[0-9A-F]{12}[1-5][0-9A-F]{3}[89AB][0-9A-F]{15}))}?$/i';  

  private $value;

  /**
   * @return string UUID /^[0-9A-F]{8}-[0-9A-F]{4}-{1-5}[0-9A-Fa-f]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/
   */
  public function __toString() {
    return $this->toString();
  }

  /**
   * @return string UUID /^[0-9A-F]{8}-[0-9A-F]{4}-{1-5}[0-9A-Fa-f]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/
   */
  public function toString() {
    return $this->value;
  }

  /**
   * @return string UUID binary string
   */
  public function toHex() {
    return pack('H*', str_replace('-', '', $this->value));
  }

  public function serialize() {
    return serialize($this->value);
  }

  public function userialize($data) {
    $this->value = unserialize($data);
  }

  private function __construct($value) {
    $this->value = $value;
  }

  /** 
   * @return UUID
   */
  public static function create() {
    return new UUID(self::generate());
  }

  /**
   * @return UUID
   * @throws UUIDException if $value is not a valid string UUID
   * @throws Exception if preg_match fail to run the regex
   */
  public static function createFromString($value) {
    $matches = [];
    $temp = preg_match(self::regex, $value, $matches);

    if ($temp !== 0 && $temp !== 1) {
      throw new Exception('Unknown error.');
    } else if (count($matches) === 0) {
      throw new UUIDException("$value is not a valid UUID.");
    } else {
      return new UUID(mb_strtoupper($matches[1]));
    }
  }

  /**
   * @return UUID
   * @throws UUIDException if $value is not a valid binary string UUID
   */
  public static function createFromHex($value) {
    $hash = unpack('H*', $value);
    $hash = array_shift($hash);

    if (strlen($hash) !== 32) {
      throw new UUIDException(sprintf('%s is not a valid UUID.', $hash));
    } else {
      $uuid = sprintf(
        '%08s-%04s-%04s-%04s-%012s',
        substr($hash, 0, 8),
        substr($hash, 8, 4), 
        substr($hash, 12,  4),
        substr($hash, 16,  4),
        substr($hash, 20, 12));
      
      return new UUID(mb_strtoupper($uuid));
    }
  }

  private static function generate() {
    list($time_mid, $time_low) = explode(' ', microtime());
    
    return mb_strtoupper(sprintf(
      '%08x-%04x-%04x-%04x-%012s',
      (int)$time_low,
      (int)substr($time_mid, 2) & 0xffff,
      mt_rand(0, 0xfff) | 0x4000,
      mt_rand(0, 0x3fff) | 0x8000,
      bin2hex(pack(
        'nN',
        function_exists('zend_thread_id')
          ? zend_thread_id()
          : getmypid(),
        ip2long(getHostByName(getHostName()))))));
  }
}
