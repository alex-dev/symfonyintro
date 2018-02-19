<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\CustomException\InvalidRangeSliderValueException;
use AppBundle\Type\UUID;
use AppBundle\Entity\QuantityPattern\Scalar;

class ProductController extends Controller {
  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';
  const manufacturer = 'AppBundle\Entity\Manufacturer';
  const product = 'AppBundle\Entity\Product\Product';
  const memory = 'AppBundle\Entity\Product\Memory';
  const memoryarch = 'AppBundle\Entity\Architecture\MemoryArchitecture';

  /**
   * @Route(
   *   "/",
   *   name="default_list_products",
   *   defaults={ "_locale"="%app.locale%" })
   * @Route(
   *   "/{_locale}/",
   *   name="list_products",
   *   requirements={ "_locale"="%app.locales%" })
   * @Method({ "GET" })
   */
  public function listProducts(EntityManagerInterface $manager, Request $request) {
    $page = ($request->query->get('page') ?: 1) - 1;
    $manufacturers = $this->convertParamToUUIDList($request->query->get('manufacturers'));

    return $this->render('products-listing.html.twig', [
      'products'=>$manager->getRepository(self::product)->findMany($page, $manufacturers),
      'filters'=>[
        'manufacturers'=>$manager->getRepository(self::manufacturer)->findManufacturerFor(self::product)
      ]
      ]);
  }

  /**
   * @Route(
   *   "/%app.routes.memory%/",
   *   name="default_list_memories",
   *   defaults={ "_locale"="%app.locale%" })
   * @Route(
   *   "/{_locale}/%app.routes.memory%/",
   *   name="list_memories",
   *   requirements={ "_locale"="%app.locales%" })
   * @Method({ "GET" })
   */
  public function listMemories(EntityManagerInterface $manager, Request $request) {
    $page = ($request->query->get('page') ?: 1) - 1;
    $manufacturers = $this->convertParamToUUIDList($request->query->get('manufacturers'));
    $architectures = $this->convertParamToUUIDList($request->query->get('architectures'));
    $size = $this->convertParamToRange($request->query->get('size'), function ($item) use (&$manager) {
      return new Scalar(
        $manager->getRepository(self::unit)->findOneBy([
          'key'=>'gigabyte'
        ]), $item);
    });
    $frequency = $this->convertParamToRange($request->query->get('frequency'), function ($item) use (&$manager) {
      return new Scalar(
        $manager->getRepository(self::unit)->findOneBy([
          'key'=>'megahertz'
        ]), $item);
    });

    return $this->render('memories-listing.html.twig', [
      'products'=>$manager->getRepository(self::memory)->findMany($page, $manufacturers, $architectures, $size, $frequency),
      'filters'=>[
        'manufacturers'=>$manager->getRepository(self::manufacturer)->findManufacturerFor(self::memory),
        'architectures'=>$manager->getRepository(self::memoryarch)->findAll(),
        'size'=>['min'=>0, 'max'=>32, 'log'=>true],
        'frequency'=>['min'=>0, 'max'=>5000]
      ]
    ]);
  }

  /**
   * @Route(
   *   "/{type}/{key}",
   *   name="default_show_product",
   *   requirements={ "type"="%app.routes.types%" },
   *   defaults={ "_locale"="%app.locale%" })
   * @Route(
   *   "/{_locale}/{type}/{key}",
   *   name="show_product",
   *   requirements={ "_locale"="%app.locales%", "type"="%app.routes.types%" })
   * @Method({ "GET" })
   */
  public function showProduct(EntityManagerInterface $manager, $type, $key) {
    if ($type == $this->container->getParameter('app.routes.memory')) {
      return $this->showMemory($manager, UUID::createFromString($key));
    }
  }

  private function showMemory(EntityManagerInterface $manager, UUID $key) {
    return $this->render('memory-showing.html.twig', [
      'product'=>$manager->getRepository(self::memory)->findByKey($key)
    ]);
  }

  private function convertParamToUUIDList($param) {
    $param = $param ?: [];

    return array_map(function ($item) {
        return UUID::createFromString($item);
      }, $param);
  }

  private function convertParamToRange($param, callable $transform) {
    if ($param != null) {
      $matches = $this->matchPattern('/\d+/', $param);

      if (count($matches) != 2) {
        throw new InvalidRangeSliderValueException("$param is not a valid range slider value.");
      } else if ($matches[0] > $matches[1]) {
        return (object)['min'=>$transform($matches[1]), 'max'=>$transform($matches[0])];
      } else {
        return (object)['min'=>$transform($matches[0]), 'max'=>$transform($matches[1])];
      }
    } else {
      return null;
    }
  }

  private function matchPattern($pattern, $subject) {
    $matches = [];
    preg_match_all($pattern, $subject, $matches);

    return $matches[0];
  }
}
