<?php
namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;

class PasswordChangeListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onPasswordChangeSuccess'];
    }

    public function onPasswordChangeSuccess(FormEvent $event)
    {
        $event->setResponse(new RedirectResponse($this->router->generate('list_products')));
    }
}
