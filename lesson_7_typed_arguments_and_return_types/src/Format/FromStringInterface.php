<?php
declare(strict_types=1);

namespace App\Format7;

interface FromStringInterface
{
    public function convertFromString(string $string);
}