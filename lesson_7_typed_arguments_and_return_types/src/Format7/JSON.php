<?php
declare(strict_types=1);
namespace App7\Format7;

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