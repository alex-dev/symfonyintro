<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
  /**
   * @Route("/", name="default_list_product", defaults={ "_locale"="%app.locale%" })
   * @Route("/{_locale}/", name="list_product", requirements={ "_locale"="%app.locales%" })
   * @Method({ "GET" })
   */
  public function listProducts()
  {
    return $this->render('base.html.twig', []);
  }

  /**
   * @Route("/{type}", name="default_list_product_type", defaults={ "_locale"="%app.locale%" })
   * @Route("/{_locale}/{type}", name="list_product_type", requirements={ "_locale"="%app.locales%", "type"="%app.routes.types%" })
   * @Method({ "GET" })
   */
  public function listProductsType()
  {
    return $this->render('base.html.twig', []);
  }
}
