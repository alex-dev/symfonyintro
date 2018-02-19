<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller {
  /**
   * @Route("/about", name="default_about", defaults={ "_locale"="%app.locale%" })
   * @Route("/{_locale}/about", name="about", requirements={ "_locale"="%app.locales%" })
   * @Method({ "GET" })
   */
  public function show() {
    return $this->render('about.html.twig', []);
  }
}
