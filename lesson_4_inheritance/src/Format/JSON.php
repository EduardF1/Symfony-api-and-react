<?php

namespace App\Format4;

class JSON extends BaseFormat
{
    // example override
    public function convert(): string
    {
        return json_encode($this->data);
    }
}