<?php

namespace App6\Format6;

class JSON extends BaseFormat implements FromStringInterface, NamedFormatInterface
{
    // concrete implementation
    public function convert(): string
    {
        return json_encode($this->data);
    }

    public function convertFromString(string $string)
    {
        return json_decode($string, true);
    }

    public function getName(): string
    {
        return 'JSON';
    }
}