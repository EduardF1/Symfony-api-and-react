<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\User;
use App\Security\TokenGenerator;

use Mailer;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Subscriber class for hashing the password of a new user upon the creation event triggering and
 * setting the confirmation token.
 * Required as API platform simply posts the data as plain text.
 * Endpoint: http://localhost:8000/api/users
 */
class PasswordHashSubscriber implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private TokenGenerator $tokenGenerator;
    private Mailer $mailer;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        TokenGenerator              $tokenGenerator,
        Mailer               $mailer
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['userRegistered', EventPriorities::PRE_WRITE],
        ];
    }

    public function userRegistered(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User ||
            !in_array($method, [Request::METHOD_POST])) {
            return;
        }

        // If it is a User, we need to hash password here
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $user->getPassword())
        );

        // Create confirmation token
        $user->setConfirmationToken(
            $this->tokenGenerator->getRandomSecureToken()
        );

        // Send an email
        $this->mailer->sendConfirmationEmail($user);
    }
}