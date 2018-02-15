<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  /**
   * @Route("/", name="homepage", defaults={ "_locale"="%default_locale%" })
   * @Route("/{_locale}/", name="local_homepage", requirements={ "_locale"="%supported_locales%" })
   * @Method({ "GET" })
   */
  public function indexAction($_locale, $_route)
  {
    return $this->render('base.html.twig', []);
  }
}
