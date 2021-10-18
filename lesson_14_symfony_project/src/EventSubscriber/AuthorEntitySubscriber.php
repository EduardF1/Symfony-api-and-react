<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\BlogPost;
use OpenApi\Tests\Fixtures\Parser\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthorEntitySubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function getAuthenticatedUser(ViewEvent $event){
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        /** @var UserInterface $author */
        $author = $this->tokenStorage->getToken()->getUser();

        if(!$entity instanceof BlogPost || Request::METHOD_POST !== $method) return;

        $entity->setAuthor($author);
    }
}