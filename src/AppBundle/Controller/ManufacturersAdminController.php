<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as Manager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\ManufacturerRepository;
use AppBundle\Entity\Manufacturer;

/**
 * @Route("/admin/manufacturers")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class ManufacturersAdminController extends Controller {
  /**
   * @Route("/", name="show_manufacturers_admin")
   * @Method({ "GET" })
   */
  public function showManufacturers(ManufacturerRepository $repo) {
    return $this->render('show-manufacturers-update.html.twig', ['manufacturers' => $repo->findAll()]);
  }

  /**
   * @Route("/", name="update_manufacturers")
   * @Method({ "POST" })
   */
  public function updateManufacturers(Request $request, ManufacturerRepository $repo, Manager $manager) {
    $data = $request->request->get('manufacturers');
    $manufacturers = $repo->findAll();

    foreach ($manufacturers as $manufacturer) {
      $manufacturer->setName($data[$manufacturer->getKey()->ToString()]);
      unset($data[$manufacturer->getKey()->ToString()]);
    }

    foreach ($data as $key => $name) {
      $manufacturer = new Manufacturer($name);
      $manager->persist($manufacturer);
      $manufacturers[] = $manufacturer;
    }

    $manager->flush();

    return $this->redirectToRoute('show_manufacturers_admin');
  }
}
