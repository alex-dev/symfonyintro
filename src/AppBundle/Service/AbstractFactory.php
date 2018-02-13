<?php
namespace AppBundle\Service;

abstract class AbstractFactory {
  abstract public function __invoke(string $value);
}
