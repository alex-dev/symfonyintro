<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as M;
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
  public function showAction(Request $request, Session $session, OrderFactory $factory, M $manager) {
    $data = [];
    foreach ($manager->getRepository('AppBundle\Entity\Item')->findAll() as $item) {
      $data[] = ['key' => $item->getProduct()->getKey(), 'quantity' => rand(0, 5)];
    }
    $data = array_filter($data, function ($item) { return $item['quantity'] > 1; });
    
    return $this->render('cart-showing.html.twig', [
      'order' => $factory($data)
    ]);
  }

  /**
   * @Route("/append/{item}", name="add_to_cart")
   * @Method({ "POST" })
   */
  public function addAction() {

  }

  /**
   * @Route("/remove/", name="empty_cart")
   * @Method({ "POST" })
   */
  public function removeAllAction() {

  }

  /**
   * @Route("/remove/{item}/", name="remove_from_cart")
   * @Method({ "POST" })
   */
  public function removeAction() {

  }

  /**
   * @Route(
   *   "/update/{type}",
   *   name="update_cart",
   *   requirements={ "type"="checkout|update" },
   *   defaults={ "type"="update" })
   * @Method({ "POST" })
   */
  public function refreshAction() {

  }
}
