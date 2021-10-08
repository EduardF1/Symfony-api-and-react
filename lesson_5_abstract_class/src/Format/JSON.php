<?php

namespace App\Format5;

class JSON extends BaseFormat
{
    // concrete implementation
    public function convert(): string
    {
        return json_encode($this->data);
    }
}