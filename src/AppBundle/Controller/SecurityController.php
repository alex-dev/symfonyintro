<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
 */
class SecurityController extends Controller {
  /**
   * @Route("/login/", name="login")
   * @Method({ "GET", "POST" })
   */
  public function loginAction(AuthenticationUtils $authentication) {
    return $this->render('login-form.html.twig', [
      'username' => $authentication->getLastUsername(),
      'error' => $authentication->getLastAuthenticationError()
    ]);
  }
}
