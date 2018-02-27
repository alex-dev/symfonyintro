<?php
namespace AppBundle\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;

class UpdateMoneyConvertersCommand extends Command
{
  const unit = 'AppBundle\Entity\QuantityPattern\Unit\Unit';

  const method = 'GET';
  const query = '?base=%0$s&symbols=%1$s';

  private $logger;
  private $manager;
  private $client;

  public function __construct(ClientInterface\Fixer $client, LoggerInterface $logger, EntityManager $manager) {
    $this->logger = $logger;
    $this->manager = $manager;
    $this->client = $client;

    parent::__construct();
  }

  protected function configure() {
    $this->setName('app:converters:money:update')
      ->setDescription('Update money converters.');
  }

  protected function execute() {
    
  }

  private function queryUnits() {
    $currencies = $manager->getRepository(self::unit)->findCurrencies();

    return [
      'currencies'=>$currencies,
      'base'=>
    ]
  }

  private function queryExchangeRates() {

  }

  private function writeExchangeRates() {

  }
}
