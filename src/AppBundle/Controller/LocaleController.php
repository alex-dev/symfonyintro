<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends Controller {
  /**
   * @Route("/updatelocale/", name="update_locale")
   * @Method({ "POST" })
   */
  public function postAction(Request $request, Session $session) {
    $session->set('_locale', $request->request->get('locale'));

    return $this->redirectToRoute($request->request->get('origin'));
  }
}
