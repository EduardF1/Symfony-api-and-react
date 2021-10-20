<?php

use App\Entity\User;
use Twig\Environment;

class Mailer
{
    private Environment $twig;
    private Swift_Mailer $mailer;

    public function __construct(
        \Swift_Mailer     $mailer,
        Environment $twig
    )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render(
            'email/confirmation.html.twig',
            [
                'user' => $user
            ]
        );

        $message = (new \Swift_Message('Hello from API Platform!'))
            ->setFrom('api-platform@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($body);

        $this->mailer->send($message);
    }
}