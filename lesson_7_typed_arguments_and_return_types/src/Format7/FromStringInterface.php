<?php
declare(strict_types=1);

namespace App7\Format7;

interface FromStringInterface
{
    public function convertFromString(string $string);
}