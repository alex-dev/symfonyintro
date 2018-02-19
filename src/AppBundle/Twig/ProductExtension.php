<?php
namespace AppBundle\Twig;

use AppBundle\Exception\UnknowProductException;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\Product\Memory;

class ProductExtension extends \Twig_Extension {
  private $memory;

  public function __construct($memory) {
    $this->memory = $memory;
  }

  public function getFilters() {
    return [
      new \Twig_SimpleFilter('product_kind', [$this, 'findProductKind']),
    ];
  }

  public function findProductKind(Product $product) {
    if ($product instanceof Memory) {
      return $this->memory;
    } else {
      throw new UnknowProductException("Could not find $product kind.");
    }
  }
}
