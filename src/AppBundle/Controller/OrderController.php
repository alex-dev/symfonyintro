<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as Manager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\Factory\OrderFactory;
use AppBundle\Type\UUID;

/**
 * @Route("/orders")
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class OrderController extends Controller {
  const item = 'AppBundle\Entity\Item';
  const order = 'AppBundle\Entity\Order\Order';

  /**
   * @Route("/", name="list_orders")
   * @Method({ "GET" })
   */
  public function listAction(OrderFactory $factory) {
    return $this->render('orders-listing.html.twig', [
      'orders' => $factory->getFromRepositoryByClient($this->getUser())
    ]);
  }

  /**
   * @Route("/{key}/", name="show_order")
   * @Method({ "GET" })
   */
  public function showAction($key, OrderFactory $factory) {
    $order = $factory->getFromRepositoryByKey(UUID::createFromString($key));
    $this->denyAccessUnlessGranted('view', $order);

    return $this->render('order-showing.html.twig', [
      'order' => $order
    ]);
  }

  /**
   * @Route("/create/", name="order_cart_form")
   * @Method({ "GET" })
   * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
   */
  public function createGetAction(Session $session, OrderFactory $factory) {
    return $this->render('billing-showing.html.twig', [
      'order' => $this->makeOrderFromSession($session->get('cart') ?: [], $factory)
    ]);
  }

  /**
   * @Route("/create/", name="order_cart_post")
   * @Method({ "POST" })
   * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
   */
  public function createPostAction(Request $request, Session $session, OrderFactory $factory, Manager $manager) {
    // TODO: Validate stripes token here. Redirect if invalid.
    $order = $this->makeOrderFromSession($session->get('cart') ?: [], $factory);

    // TODO: Add stripes token to order here.

    $manager->persist($order);
    
    $products = $manager->getRepository(self::item)->findItemsByProductKeys(
      array_map(function ($item) { return $item->getProduct()->getKey(); }, $order)
    );

    foreach ($products as $product) {
      $orderitem = array_filter($order, function ($item) use ($product) {
        return $item->getProduct()->getKey() == $product->getProduct()->getKey();
      })[0];
      $product->setCount($product->getCount() - $orderitem->getQuantity());
    }

    $manager->flush();

    return $this->redirectToRoute('show_order', ['key' => $order->getKey()]);
  }

  private function makeOrderFromSession($data, OrderFactory $factory) {
    return $factory(
      array_map(function ($item) { return [
        'key' => UUID::createfromString($item['key']),
        'quantity' => $item['quantity'],
      ]; }, $data));
  }
}
