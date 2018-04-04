<?php
namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;

class ProfileChangeListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onProfileEditSuccess'];
    }

    public function onProfileEditSuccess(FormEvent $event)
    {
        $event->setResponse(new RedirectResponse($this->router->generate('list_products')));
    }
}
