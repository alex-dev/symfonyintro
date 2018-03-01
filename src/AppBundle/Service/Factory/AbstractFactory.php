<?php
namespace AppBundle\Service\Factory;

abstract class AbstractFactory {
  abstract public function __invoke($value);
}
