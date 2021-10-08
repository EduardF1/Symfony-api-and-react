<?php
declare(strict_types=1);

namespace App8\Format8;

interface FromStringInterface
{
    public function convertFromString(string $string);
}