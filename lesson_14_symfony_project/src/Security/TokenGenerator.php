<?php

namespace App\Security;

class TokenGenerator
{
    private const ALPHANUMERIC = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function getRandomSecureToken(int $length = 30): string
    {
        $token = '';
        $maxNumber = strlen(self::ALPHANUMERIC);
        for ($i = 0; $i < $length; $i++){
            $token.=self::ALPHANUMERIC[random_int(0, $maxNumber - 1)];
        }
        return $token;
    }
}