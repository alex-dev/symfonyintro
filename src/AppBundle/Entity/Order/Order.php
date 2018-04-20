<?php
namespace AppBundle\Entity\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\UrlKey;
use AppBundle\Entity\Client\Client;
use AppBundle\Entity\Order\OrderItem;
use AppBundle\Entity\Order\State;
use AppBundle\Service\CostCalculator;
use AppBundle\Type\UUID;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_Orders_key", columns={ "`key`" })
 *   })
 * @UniqueEntity("key")
 */
class Order extends UrlKey {
  protected $calculator;

  public function setCalculator(CostCalculator $value) {
    $this->calculator = $value;
  }

  /**
   * @ORM\Id
   * @ORM\Column(type="bigint", options={ "unsigned":true })
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * Not Implemented
   */
  protected $stripeToken;

  /**
   * @ORM\Column(type="string", length=20)
   */
  protected $state;

  public function getState() {
    return $this->state;
  }

  /**
   * @ORM\Column(type="datetime")
   */
  protected $date;
  
  public function getDate() {
    return $this->date;
  }

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client\Client", inversedBy="orders")
   * @ORM\JoinColumn(nullable=false)
   */
  protected $client;

  public function getClient() {
    return $this->client;
  }

  protected function setClient(Client $value) {
    $this->client = $value;
  }

  /**
   * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={ "persist" })
   */
  protected $items;

  public function getItems() {
    return $this->items->toArray();
  }

  public function addItem(OrderItem $value) {
    $value->setOrder($this);
    $this->items->add($value);
  }

  protected function setItems(array $value) {
    foreach ($value as $item) {
      $item->setOrder($this);
    }

    $this->items = new ArrayCollection($value);
  }

  /**
   * @return ['cost', 'taxes', 'delivery']
   */
  public function getCost() {
    $temp = $this->calculator;
    return $temp($this->getItems());
  }

  public function __construct(array $items, Client $client, CostCalculator $calculator) {
    parent::__construct();
    $this->state = State::valid;
    $this->date = new \DateTime();
    $this->setCalculator($calculator);
    $this->setItems($items);
    $this->setClient($client);
  }

  public function isCancelled() {
    return $this->state == State::cancelled;
  }

  public function cancel() {
    $this->state = State::cancelled;
  }
}

