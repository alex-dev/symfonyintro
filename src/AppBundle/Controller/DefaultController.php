<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  /**
   * @Route("/", name="list_products", defaults={ "_locale"="%app.locale%" })
   * @Route("/{_locale}/", name="local_list_products", requirements={ "_locale"="%app.locales%" })
   * @Method({ "GET" })
   */
  public function indexAction()
  {
    return $this->render('base.html.twig', []);
  }
}
