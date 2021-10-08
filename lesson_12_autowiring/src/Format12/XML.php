<?php

namespace App12\Format12;

class XML extends BaseFormat
    implements NamedFormatInterface,
    FormatInterface {
    public function convert(): string
    {
        $result = '';

        foreach ($this->data as $key => $value) {
            $result .= '<'.$key.'>'.$value.'</'.$key.'>';
        }

        return htmlspecialchars($result);
    }

    public function getName(): string
    {
        return 'XML';
    }
}