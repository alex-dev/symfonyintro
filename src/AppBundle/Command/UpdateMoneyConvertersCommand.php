<?php
namespace AppBundle\Command;

use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;
use Psr7\Http\Message\ResponseInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\ParameterBag;
use AppBundle\Entity\QuantityPattern\Unit\Unit;

class UpdateMoneyConvertersCommand extends Command
{
  const name = 'app:converters:money:update';

  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';

  const base = 'base';
  const symbols = 'symbols';

  private $manager;
  private $logger;
  private $serializer;
  private $client;

  public function __construct(ClientInterface\Fixer $client, SerializerInterface $serializer, LoggerInterface $logger, EntityManager $manager) {
    $this->manager = $manager;
    $this->logger = $logger;
    $this->serializer = $serializer;
    $this->client = $client;

    parent::__construct();
  }

  protected function configure() {
    $this->setName(self::name);
  }

  protected function execute() {
    list($units, $base) = $this->queryUnits();
    $this->queryExchangeRates(
      $base->getKey(),
      $units->map(function (Unit $item) { return $item->getKey(); }))
      ->then(function (ParameterBag $reponse) use ($units) {
        $this->writeExchangeRates($response, $units);
        $this->manager->persist($units);
        return $units;
      });
  }

  private function queryUnits() {
    $currencies = $manager->getRepository(self::unit)->findCurrencies();

    return [
      'currencies'=>$currencies,
      'base'=>$currencies->filter(function (Unit $item) {
        return $item->isMain()->first();
      })
    ];
  }

  private function queryExchangeRates($base, Collection $rates) {
    $params = 
    $promise = $this->$client->getAsync('/', [
      'query' => [
        self::base => $base,
        self::symbols => $implode(',', $rates->toArray())
      ]
    ])->then(function (ResponseInterface $reponse) {
      list($base, $rates) = $this->serializer->decode($response->getBody());
      $results = new ParameterBag($rates);
      $results->set($base, 1);
      return $results;
    });
  }

  private function writeExchangeRates(ParameterBag $rates, Collection $units) {
    foreach ($units->getIterator() as $unit) {
      $unit->getConverter()->setFactor
    }
  }
}
