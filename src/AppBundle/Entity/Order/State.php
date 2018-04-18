<?php
namespace AppBundle\Entity\Order;

use MyCLabs\Enum\Enum;

final class State extends Enum {
  const valid = 'valid';
  const cancelled = 'cancelled';
}
