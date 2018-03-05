<?php
namespace AppBundle\Subscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleSubscriber implements EventSubscriberInterface {
  private $default;
  private $accepted;

  public function __construct($default, $accepted) {
    $this->default = $default;
    $this->accepted = '/^(?:'.implode(')|(?:', explode('|', $accepted)).')$/';
  }

  public function onKernelRequest(GetResponseEvent $event) {
    $request = $event->getRequest();

    if ($request->hasPreviousSession()) {
      $this->setLocale($request, $request->getSession()->get('_locale', $this->default));
    } else {
      $this->setLocale($request, $this->default);
    }
  }

  public static function getSubscribedEvents() {
    return [KernelEvents::REQUEST => [['onKernelRequest', 20]]];
  }

  private function setLocale(Request $request, $locale) {
    $request->setLocale(preg_match($this->accepted, $locale) ? $locale : $this->default);
  }
}
