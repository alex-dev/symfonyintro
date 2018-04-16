<?php	
namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\Order\Order;

class OrderVoter extends Voter {
  const VIEW = 'view';

  private $aclManager;

  public function __construct(AccessDecisionManagerInterface $aclManager) {
      $this->aclManager = $aclManager;
  }

  protected function supports($attribute, $subject) {
    return in_array($attribute, [self::VIEW]) && $subject instanceof Order;
  }

  protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
    return $this->aclManager->decide($token, ['ROLE_ADMIN'])
      || ($subject->getClient()->getUsername() == $token->getUser()->getUsername()
        && in_array($subject->getKey(), array_map(function($item) { return $item->getKey(); }, $token->getUser()->getOrders())));
  }
}