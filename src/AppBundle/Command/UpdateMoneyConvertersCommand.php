<?php
namespace AppBundle\Command;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use GuzzleHttp\ClientInterface as Client;
use Psr\Log\LoggerInterface as Logger;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use AppBundle\Entity\QuantityPattern\Unit\Unit;

class UpdateMoneyConvertersCommand extends Command
{
  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';

  const base = 'base';
  const symbols = 'symbols';

  private $manager;
  private $logger;
  private $serializer;
  private $client;

  public function __construct(Client $client, Serializer $serializer, Logger $logger, EntityManager $manager) {
    $this->manager = $manager;
    $this->logger = $logger;
    $this->serializer = $serializer;
    $this->client = $client;

    parent::__construct();
  }

  protected function configure() { }

  protected function execute(Input $input, Output $output) {
    extract($this->queryUnits());
    $this->queryExchangeRates(
      $base->getKey(),
      $units->map(function (Unit $item) { return $item->getKey(); }))
      ->then(function (ParameterBag $rates) use ($units) {
        $this->updateExchangeRates($rates, $units);
      })
      ->wait();
    $this->manager->flush();      
  }

  private function queryUnits() {
    $currencies = $this->manager->getRepository(self::unit)->findCurrencies();

    return [
      'units'=>$currencies,
      'base'=>$currencies->filter(function (Unit $item) {
        return $item->isMain();
      })->first()
    ];
  }

  private function queryExchangeRates($base, Collection $rates) {
    return $this->client->getAsync('', [
      'query' => [
        self::base => $base,
        self::symbols => implode(',', $rates->toArray())
      ]
    ])->then(function (Response $response) {
      extract($this->serializer->decode($response->getBody(), 'json'));
      $results = new ParameterBag($rates);
      $results->set($base, 1);
      return $results;
    });
  }

  private function updateExchangeRates(ParameterBag $rates, Collection $units) {
    foreach ($units->getIterator() as $unit) {
      $unit->getConverter()->updateFactor($rates->get($unit->getKey()));
    }
  }
}
