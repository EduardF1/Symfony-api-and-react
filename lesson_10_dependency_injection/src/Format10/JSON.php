<?php
declare(strict_types=1);

namespace App10\Format10;

class JSON extends BaseFormat
    implements FromStringInterface,
    NamedFormatInterface,
    FormatInterface {
    public function convert(): string
    {
        return json_encode($this->data);
    }

    public function convertFromString($string)
    {
        return json_decode($string, true);
    }

    public function getName(): string
    {
        return 'JSON';
    }
}