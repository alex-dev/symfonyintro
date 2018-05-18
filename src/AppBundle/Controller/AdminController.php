<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends Controller {
  /**
   * @Route("/", name="show_admin_menu")
   * @Method({ "GET" })
   */
  public function showMenu() {
    return $this->render('admin-menu.html.twig');
  }
}
