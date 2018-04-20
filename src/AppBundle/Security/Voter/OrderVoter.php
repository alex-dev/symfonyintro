<?php	
namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\Order\Order;

class OrderVoter extends Voter {
  const VIEW = 'view';
  const CANCEL = 'cancel';

  private $aclManager;

  public function __construct(AccessDecisionManagerInterface $aclManager) {
      $this->aclManager = $aclManager;
  }

  protected function supports($attribute, $subject) {
    return in_array($attribute, [self::VIEW, self::CANCEL]) && $subject instanceof Order;
  }

  protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
    switch($attribute) {
      case self::VIEW:
        return $this->aclManager->decide($token, ['ROLE_ADMIN']) || $this->voteOnView($subject, $token->getUser());
      case self::CANCEL:
        return $this->aclManager->decide($token, ['ROLE_ADMIN']) || $this->voteOnCancel($subject, $token->getUser());
      default:
        return $this->aclManager->decide($token, ['ROLE_ADMIN']);
    }
  }

  private function voteOnView($subject, $user) {
    return $subject->getClient()->getUsername() == $user->getUsername()
        && in_array($subject->getKey(), array_map(function($item) { return $item->getKey(); }, $user->getOrders()));
  }

  private function voteOnCancel($subject, $user) {
    $interval = (new \DateTime)->diff($subject->getDate());
    return ($interval->days + $interval->h / 24 + $interval->m / (60 * 24) + $interval->s / (60 * 60 * 24)) < 2;
  }
}