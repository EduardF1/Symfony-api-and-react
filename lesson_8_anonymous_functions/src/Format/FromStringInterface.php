<?php
declare(strict_types=1);

namespace App\Format8;

interface FromStringInterface
{
    public function convertFromString(string $string);
}