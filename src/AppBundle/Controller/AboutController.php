<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends Controller {
  /**
   * @Route("/about/", name="about")
   * @Method({ "GET" })
   */
  public function showAction() {
    return $this->render('about.html.twig', []);
  }
}
