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
 * @Route("/admin/orders")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class OrdersAdminController extends Controller {
  /**
   * @Route("/", name="show_orders_admin")
   * @Method({ "GET" })
   */
  public function showOrders(OrderFactory $factory) {
    return $this->render('orders-listing.html.twig', [
      'orders' => $factory->getAllFromRepository(),
      'admin' => true
    ]);
  }
}
