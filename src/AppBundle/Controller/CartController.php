<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\Factory\OrderFactory;
use AppBundle\Type\UUID;

/**
 * @Route("/account/cart")
 * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
 */
class CartController extends Controller {
  /**
   * @Route("/", name="show_cart")
   * @Method({ "GET" })
   */
  public function showAction(Session $session, OrderFactory $factory, Securyt) {
    return $this->render('cart-showing.html.twig', [
      'order' => $factory(
        array_map(function ($item) { return [
          'key' => UUID::createfromString($item['key']),
          'quantity' => $item['quantity'],
        ]; }, $session->get('cart') ?: []),
        $this->isGranted('IS_AUTHENTICATED_FULLY') ? $this->getUser() : null)
    ]);
  }

  /**
   * @Route("/append/", name="add_to_cart")
   * @Method({ "POST" })
   */
  public function addAction(Session $session, Request $request) {
    $data = $session->get('cart') ?: [];
    $arr = array_map(function ($item) { return $item['key']; }, $data);
    $arr = array_combine(array_values($arr), array_keys($arr));

    if (key_exists($request->request->get('item'), $arr)) {
      $data[$arr[$request->request->get('item')]]['quantity']++;
    } else {
      $data[] = [
        'key' => $request->request->get('item'),
        'quantity' => 1
      ];
    }
    
    $session->set('cart', $data);
    return $this->redirect($request->headers->get('referer'));    
  }

  /**
   * @Route("/remove/", name="empty_cart")
   * @Method({ "POST" })
   */
  public function removeAllAction(Session $session, Request $request) {
    $session->remove('cart');
    return $this->redirect($request->headers->get('referer'));    
  }

  /**
   * @Route("/remove/{item}/", name="remove_from_cart")
   * @Method({ "POST" })
   */
  public function removeAction(Session $session, Request $request, $item) {
    $session->set('cart', array_filter(
      $session->get('cart'),
      function ($key) use ($item) { return $key['key'] != $item; }));

    return $this->redirect($request->headers->get('referer'));    
  }

  /**
   * @Route(
   *   "/update/{type}",
   *   name="update_cart",
   *   requirements={ "type"="checkout|update" },
   *   defaults={ "type"="update" })
   * @Method({ "POST" })
   */
  public function refreshAction(Session $session, Request $request, $type) {
    $data = $request->request->get('cartitems');
    $session->set('cart', array_filter(
      array_map(function ($item) use ($data) {
        return [
          'key' => $item['key'],
          'quantity' => $data[$item['key']]
        ];
      }, $session->get('cart')),
      function($item) { return $item['quantity'] > 0; }));
    
    switch ($type) {
      case 'update':
        return $this->redirect($request->headers->get('referer'));    
      case 'checkout':
        return $this->redirectToRoute('order_cart_form');    
    }
  }
}
