<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as Manager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Product\Memory;
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
   * @Route("/{type}/create/", name="show_create_admin", requirements={ "type"="%app.routes.types%" })
   * @Method({ "GET" })
   */
  public function showCreateProduct($type, ItemRepository $repo) {
    return $this->render('product-form.html.twig', [
      'form' => $this->createForm_($this->createDefault($type, $repo))->createView()
    ]);
  }

  /**
   * @Route("/{type}/create/", name="create_product", requirements={ "type"="%app.routes.types%" })
   * @Method({ "POST" })
   */
  public function createProduct($type, Request $request, ItemRepository $repo, Manager $manager) {
    $form = $this->createForm_($this->createDefault($type, $repo));
    $form->handleRequest($request);
    
    if ($form->isValid()) {
      $product = $form->getData();
      $manager->persist($product->getProduct());
      $manager->flush(); // Ce flush crée l'id du produit, puis le flush suivant crée l'item.
      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('show_product_admin', [
        'key' => $product->getProduct()->getKey()->toString(),
        'type' => $type
      ]);
    } else {
      return $this->render('product-form.html.twig', [
        'form' => $form->createView()
      ]);
    }
  }

  /**
   * @Route("/{type}/{key}/", name="show_product_admin")
   * @Method({ "GET" })
   */
  public function showProduct($key, ItemRepository $repo) {
    $product = $repo->findByKey(UUID::createFromString($key));
    return $this->render('product-form.html.twig', [
      'form' => $this->createForm_($product)->createView(),
      'product' => $product
    ]);
  }

  /**
   * @Route("/{type}/{key}/", name="update_product")
   * @Method({ "POST" })
   */
  public function updateProduct($key, $type, Request $request, ItemRepository $repo, Manager $manager) {
    $product = $repo->findByKey(UUID::createFromString($key));
    $filenames = array_map(
      function ($file) { return $file->getFilename(); },
      $product->getProduct()->getImages());
    $form = $this->createForm_($product);
    $form->handleRequest($request);
    
    if ($form->isValid()) {
      $product = $form->getData();
      foreach ($product->getProduct()->getImages() as $index => $image) {
        if ($image->getFilename() == null) {
          $image->setFilename($filenames[$index]);
        }
      }

      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('show_product_admin', [
        'key' => $key,
        'type' => $type
      ]);
    } else {
      return $this->render('product-form.html.twig', [
        'form' => $form->createView(),
        'product' => $product
      ]);
    }
  }

  private function createForm_($product) {
    if ($product->getProduct() instanceof Memory) {
      return $this->createForm(ItemType::class, $product, ['product_class' => MemoryType::class]);
    }
  }

  private function createDefault($type, ItemRepository $repo) {
    if ($type == $this->container->getParameter('app.routes.memory')) {
      return $repo->getDefaultMemory();
    }
  }
}
