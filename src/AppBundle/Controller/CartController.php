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
      $data[] = $item->getProduct()->getKey();
    }
    
    return $this->render('cart-showing.html.twig', [
      'order' => $factory($data)
    ]);
  }
}
