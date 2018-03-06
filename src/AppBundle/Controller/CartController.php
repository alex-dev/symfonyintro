<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\Factory\OrderFactory;

/**
 * @Route("/account/cart")
 */
class CartController extends Controller {
  /**
   * @Route("/", name="show_cart")
   * @Method({ "GET" })
   */
  public function showAction(Session $session, OrderFactory $factory) {
    return $this->render('cart-showing.html.twig', [
      'order' => $factory($session->get('cart'))
    ]);
  }

  /**
   * @Route("/append/{item}", name="add_to_cart")
   * @Method({ "POST" })
   */
  public function addAction(Session $session) {

  }

  /**
   * @Route("/remove/", name="empty_cart")
   * @Method({ "POST" })
   */
  public function removeAllAction(Session $session) {
    $session->remove('cart');
    return $this->redirectToRoute('show_cart');
  }

  /**
   * @Route("/remove/{item}/", name="remove_from_cart")
   * @Method({ "POST" })
   */
  public function removeAction(Session $session) {

  }

  /**
   * @Route(
   *   "/update/{type}",
   *   name="update_cart",
   *   requirements={ "type"="checkout|update" },
   *   defaults={ "type"="update" })
   * @Method({ "POST" })
   */
  public function refreshAction(Session $session) {

  }
}
