<?php
declare(strict_types=1);

namespace App9\Format9;

interface FromStringInterface
{
    public function convertFromString(string $string);
}