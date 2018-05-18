<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as Manager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\ItemType;
use AppBundle\Form\MemoryType;
use AppBundle\Repository\ItemRepository;
use AppBundle\Type\UUID;

/**
 * @Route("/admin/inventory")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class InventoryController extends Controller {
  /**
   * @Route("/full/", name="show_inventory_full")
   * @Method({ "GET" })
   */
  public function showFullInventory(ItemRepository $repo) {
    return $this->render('inventory-show.html.twig', [
      'products' => $repo->findAll()
    ]);
  }

  /**
   * @Route("/backorder/", name="show_inventory_backorder")
   * @Method({ "GET" })
   */
  public function showBackorderInventory(ItemRepository $repo) {
    return $this->render('inventory-show.html.twig', [
      'products' => $repo->findBackorder()
    ]);
  }

  /**
   * @Route("/{key}/", name="show_product_admin")
   * @Method({ "GET" })
   */
  public function showProduct($key, ItemRepository $repo) {
    return $this->render('product-form.html.twig', [
      'form' => $this->createForm_($repo->findByKey(UUID::createFromString($key)))->createView()
    ]);
  }

  /**
   * @Route("/{key}/", name="update_product")
   * @Method({ "PUT" })
   */
  public function updateProduct($key, Request $request, ItemRepository $repo, Manager $manager) {
    $form = $this->createForm_($repo->findByKey(UUID::createFromString($key)))->createView();
    $form->handleRequest($request);
    
    if ($form->isValid()) {
      $product = $form->getData();

      foreach($product->getImages() as $image) {
        $file = $image->getFilename();
        $name = md5(uniqid());
        $file->move($this->getParameter('databasemedia'), $name.'.png');
        $image->setFilename($name);
      }

      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('show_product_admin', $product->getKey()->toString());
    } else {
      return $this->render('product-form.html.twig', [
        'form' => $form->createView()
      ]);
    }
  }

  /**
   * @Route("/create/{type}", name="show_create_admin", requirements={ "type"="%app.routes.types%" })
   * @Method({ "GET" })
   */
  public function showCreateProduct($type, ItemRepository $repo) {
    return $this->render('product-form.html.twig', [
      'form' => $this->createForm_($this->createDefault($type, $repo))->createView()
    ]);
  }

  /**
   * @Route("/create/{type}/", name="create_product", requirements={ "type"="%app.routes.types%" })
   * @Method({ "POST" })
   */
  public function createProduct($type, Request $request, ItemRepository $repo, Manager $manager) {
    $form = $this->createForm_($this->createDefault($type, $repo))->createView();
    $form->handleRequest($request);
    
    if ($form->isValid()) {
      $product = $form->getData();

      foreach($product->getImages() as $image) {
        $file = $image->getFilename();
        $name = md5(uniqid());
        $file->move($this->getParameter('databasemedia'), $name.'.png');
        $image->setFilename($name);
      }

      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('show_product_admin', $product->getKey()->toString());
    } else {
      return $this->render('product-form.html.twig', [
        'form' => $form->createView()
      ]);
    }
  }

  private function createForm_($product) {
    if ($product instanceof Memory) {
      return $this->createForm(ItemType::class, $product, ['product_class' => MemoryType::class]);
    }
  }

  private function createDefault($type, ItemRepository $repo) {
    if ($type == $this->container->getParameter('app.routes.memory')) {
      return $repo->getDefaultMemory();
    }
  }
}
