<?php
namespace AppBundle\Service\Factory;

use GuzzleHttp\Client;
use AppBundle\Service\Factory\AbstractFactory;

final class ClientAPIFactory extends AbstractFactory {
  private $timeout;

  public function __construct($timeout) {
    $this->timeout = $timeout;
  }

  /**
   * @return ClientInterface
   */
  public function __invoke($baseUri) {
    return new Client([
      'base_uri'=>$baseUri,
      'timeout'=>$this->timeout]);
  }
}
